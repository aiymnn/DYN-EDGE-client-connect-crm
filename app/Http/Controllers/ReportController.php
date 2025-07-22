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

        return Excel::download(new CustomersExport($filters), 'customers_report.xlsx');
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

        return Excel::download(new TicketsExport($filters), 'tickets_report.xlsx');
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

        return Excel::download(new InteractionsExport($filters), 'interactions_report.xlsx');
    }

    public function exportStaffs(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'status']);
        return Excel::download(new StaffsExport($filters), 'staffs_report.xlsx');
    }
}
