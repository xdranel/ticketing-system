<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::query()
            ->with(['customer', 'assignee'])
            ->latest()
            ->paginate(10);

        $totalTickets = Ticket::count();

        $ticketsCounts = Ticket::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('pages.dashboard.admin', compact( 'ticketsCounts', 'totalTickets'));
    }
}
