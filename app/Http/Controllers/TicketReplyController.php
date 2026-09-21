<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketReplyRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketReplyRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->authorize('reply', $ticket);

        $ticket->replies()->create([
            'user_id' => $request->user()->id,
            'message' => $request->validated('message'),
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Reply sent successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
