<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $agent = $request->user();

        $assignedTickets = $agent->assignedTickets();

        $totalTickets = $assignedTickets->count();

        $ticketsCounts = $assignedTickets
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('pages.dashboard.agent', compact('totalTickets', "ticketsCounts"));
    }
}
