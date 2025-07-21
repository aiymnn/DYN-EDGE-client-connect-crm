<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $totalStaff = User::where('role', 'R02')->count();

        // Total Customers
        $totalCustomers = $isAdmin
            ? Customer::count()
            : Customer::whereIn('id', function ($query) use ($user) {
                $query->select('customer_id')
                    ->from('interactions')
                    ->where('user_id', $user->id)
                    ->whereNotNull('customer_id');
            })->distinct()->count();

        // Total Tickets & Interactions
        $totalTickets = Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->count();
        $totalInteractions = Interaction::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->count();

        // Recent Interactions
        $recentInteractions = Interaction::with(['customer', 'staff'])
            ->when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(5)
            ->get();

        // Recent Tickets
        $recentTickets = Ticket::with(['customer', 'staff'])
            ->when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(5)
            ->get();

        // Pending Follow-Ups
        $pendingFollowUps = Ticket::with(['customer', 'staff'])
            ->when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->whereIn('status', ['open', 'in_progress'])
            ->latest()
            ->take(5)
            ->get();

        // Doughnut Ticket Status Counts
        $doughnutTicketStatusCounts = [
            'Open' => Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->where('status', 'open')->count(),
            'In Progress' => Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->where('status', 'in_progress')->count(),
            'Resolved' => Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->where('status', 'resolved')->count(),
            'Closed' => Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))->where('status', 'closed')->count(),
        ];

        // Doughnut Interaction Type Counts
        $doughnutInteractionTypeCounts = Interaction::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Year filter for bar chart
        $availableYears = Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $currentYear = $request->input('year', now()->year);

        // Bar Chart: Tickets Created Per Month
        $barTicketsPerMonthCounts = Ticket::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
            ->selectRaw('MONTH(created_at) as month_num, DATE_FORMAT(created_at, "%M") as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_num', 'month')
            ->orderBy('month_num')
            ->pluck('count', 'month')
            ->toArray();

        // chart reload
        if ($request->wantsJson()) {
            return response()->json($barTicketsPerMonthCounts);
        }

        return view('dashboard', compact(
            'totalStaff',
            'totalCustomers',
            'totalTickets',
            'totalInteractions',
            'recentInteractions',
            'recentTickets',
            'pendingFollowUps',
            'doughnutTicketStatusCounts',
            'barTicketsPerMonthCounts',
            'doughnutInteractionTypeCounts',
            'availableYears',
            'currentYear'
        ));
    }
}
