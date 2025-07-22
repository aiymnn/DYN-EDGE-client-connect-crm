<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\InteractionsExport;
use App\Exports\StaffsExport;
use App\Exports\TicketsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.reports.index');
    }

    public function exportCustomers(Request $request)
    {
        $filters = $request->only([
            'start_date',
            'end_date',
            'status',
        ]);

        return Excel::download(new CustomersExport($filters), 'customers_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportTickets(Request $request)
    {
        $filters = $request->only([
            'start_date',
            'end_date',
            'status',
            'priority',
            'name',
        ]);

        if (!auth()->user()->isAdmin()) {
            $filters['staff_id'] = auth()->id();
        }

        return Excel::download(new TicketsExport($filters), 'tickets_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportInteractions(Request $request)
    {
        $filters = $request->only([
            'start_date',
            'end_date',
            'type',
            'name',
            'staff',
        ]);

        if (!auth()->user()->isAdmin()) {
            $filters['staff_id'] = auth()->id();
        }

        return Excel::download(new InteractionsExport($filters), 'interactions_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportStaffs(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'status']);
        return Excel::download(new StaffsExport($filters), 'staffs_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
}
