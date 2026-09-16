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
        $tickets = $request->user()
            ->assignedTickets()
            ->with('customer')
            ->latest()
            ->paginate(10);
        return view('pages.dashboard.agent', compact('tickets'));
    }
}
