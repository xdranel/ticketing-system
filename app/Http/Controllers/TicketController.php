<?php

namespace App\Http\Controllers;

use App\Enums\TicketCategory;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Ticket::class);

        $query = match ($request->user()->role) {
            UserRole::Customer => $request->user()->tickets(),
            UserRole::Agent => $request->user()->assignedTickets(),
            UserRole::Admin => Ticket::query(),
        };

        $tickets = $query->with(['customer', 'assignee'])
            ->latest()
            ->paginate(10);

        return view('pages.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $customers = $request->user()->role === UserRole::Admin
            ? User::query()->where('role', UserRole::Customer->value)->orderBy('name')->get()
            : collect();

        return view('pages.ticket.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $validated = $request->validated();

        $customer = $request->user();

        if ($request->user()->role === UserRole::Admin) {
            $customer = User::query()
                ->where('role', UserRole::Customer->value)
                ->findOrFail($validated['customer_id']);
            unset($validated['customer_id']);
        }

        $attachments = $request->file('attachments', []);
        unset($validated['attachments']);

        $ticket = $customer->tickets()->create($validated);

        foreach ($attachments as $file) {
            $path = $file->store('', 'attachments');

            $ticket->attachments()->create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load(['customer', 'assignee', 'attachments']);

        return view('pages.ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket, Request $request)
    {
        $this->authorize('update', $ticket);

        $agents = $request->user()->role === UserRole::Admin
            ? User::query()->where('role', UserRole::Agent->value)->orderBy('name')->get()
            : collect();

        return view('pages.ticket.edit', compact('ticket', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $validated = $request->validated();
        $status = TicketStatus::from($validated['status']);

        $ticket->priority = TicketPriority::from($validated['priority']);
        $ticket->status = $status;
        $ticket->closed_at = $status === TicketStatus::Closed ? now() : null;

        if ($request->user()->role === UserRole::Admin) {
            $ticket->assigned_to = $validated['assigned_to'] ?? null;
        }

        $ticket->save();

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
