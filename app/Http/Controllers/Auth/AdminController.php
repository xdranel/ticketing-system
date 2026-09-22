<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $tickets = Ticket::query()
            ->with(['customer', 'assignee'])
            ->whereNull('assigned_to')
            ->latest()
            ->paginate(10);
        return view('pages.dashboard.admin', compact('tickets'));
    }
}
