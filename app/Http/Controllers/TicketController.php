<?php

namespace App\Http\Controllers;

use App\Enums\TicketCategory;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        private ActivityLogService $activityLog
    )
    {

    }

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

        $query->with(['customer', 'assignee'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('reference', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', TicketCategory::from($request->input('category')));
            })
            ->when($request->filled('priority'), function ($query) use ($request) {
                $query->where('priority', TicketPriority::from($request->input('priority')));
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', TicketStatus::from($request->input('status')));
            })
            ->latest();


        $tickets = $query
            ->paginate(10)
            ->withQueryString();

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

        $this->activityLog->log(
            ticket: $ticket,
            actor: $request->user(),
            action: 'ticket.created',
            description: 'Ticket was created',
            visibility: 'public'
        );

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
        $ticket->load([
            'customer',
            'assignee',
            'attachments',
            'replies.user'
        ]);

        $activities = ActivityLog::where('ticket_id', $ticket->id)
            ->where('ticket_reference', $ticket->reference)
            ->orderByDesc('created_at')
            ->get();

        return view('pages.ticket.show', compact('ticket', 'activities'));
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

        $oldStatus = $ticket->status;
        $oldPriority = $ticket->priority;
        $oldAssignedId = $ticket->assigned_to;

        $newStatus = TicketStatus::from($validated['status']);
        $newPriority = TicketPriority::from($validated['priority']);

        $ticket->priority = $newPriority;
        $ticket->status = $newStatus;

        $ticket->closed_at = $newStatus === TicketStatus::Closed
            ? now()
            : null;

        if ($request->user()->role === UserRole::Admin) {
            $ticket->assigned_to = $validated['assigned_to'] ?? null;
        }

        $ticket->save();

        if ($oldStatus !== $ticket->status) {
            $this->activityLog->log(
                ticket: $ticket,
                actor: $request->user(),
                action: 'ticket.status_changed',
                description: sprintf(
                    'Ticket status changed from %s to %s',
                    $oldStatus->value,
                    $ticket->status->value
                ),
                metadata: [
                    'old_status' => $oldStatus->value,
                    'new_status' => $ticket->status->value,
                ],
            );
        }

        if ($oldPriority !== $ticket->priority) {
            $this->activityLog->log(
                ticket: $ticket,
                actor: $request->user(),
                action: 'ticket.priority_changed',
                description: sprintf(
                    'Ticket priority changed from %s to %s',
                    $oldPriority->value,
                    $ticket->priority->value
                ),
                metadata: [
                    'old_priority' => $oldPriority->value,
                    'new_priority' => $ticket->priority->value,
                ],
            );
        }

        if ($oldAssignedId !== $ticket->assigned_to) {
            $oldAssignee = $oldAssignedId
                ? User::find($oldAssignedId)
                : null;

            $newAssignee = $ticket->assigned_to
                ? User::find($ticket->assigned_to)
                : null;

            $oldAssigneeName = $oldAssignee?->name ?? 'Unassigned';
            $newAssigneeName = $newAssignee?->name ?? 'Unassigned';
        }

        $this->activityLog->log(
            ticket: $ticket,
            actor: $request->user(),
            action: 'ticket.assigned',
            description: sprintf(
                'Ticket assigned from %s to %s',
                $oldAssigneeName,
                $newAssigneeName
            ),
            metadata: [
                'old_assignee_id' => $oldAssignedId,
                'old_assignee_name' => $oldAssigneeName,
                'new_assignee_id' => $ticket->assigned_to,
                'new_assignee_name' => $newAssigneeName,
            ]
        );

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
