<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
//        $tickets = $request->user()
//            ->tickets()
//            ->where('status', '!=', 'closed')
//            ->where('status', '!=', 'in_progress')
//            ->latest()
////            ->paginate(10);
//        $tickets = $request->user()
//            ->tickets()
//            ->latest()
//            ->paginate(10);

        $ticketsCounts = $request->user()
            ->tickets()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('pages.dashboard.customer', compact('ticketsCounts'));
    }
}
