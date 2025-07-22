<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\InteractionsExport;
use App\Exports\StaffsExport;
use App\Exports\TicketsExport;
use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.reports.index');
    }

    // csv
    public function exportCustomers(Request $request)
    {
        $filters = $request->only([
            'start_date',
            'end_date',
            'status',
        ]);

        if ($request->input('format') === 'pdf') {
            return $this->exportCustomersPdf($filters);
        }

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

        if ($request->input('format') === 'pdf') {
            return $this->exportTicketsPdf($filters);
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

        if ($request->input('format') === 'pdf') {
            return $this->exportInteractionsPdf($filters);
        }

        return Excel::download(new InteractionsExport($filters), 'interactions_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportStaffs(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'status']);


        if ($request->input('format') === 'pdf') {
            return $this->exportStaffsPdf($filters);
        }

        return Excel::download(new StaffsExport($filters), 'staffs_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }


    //pdf
    public function exportCustomersPdf(array $filters)
    {
        $customers = Customer::withCount(['interactions', 'tickets'])
            ->filter($filters)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.customers_pdf', [
            'customers' => $customers,
            'filters' => $filters,
        ]);

        return $pdf->download('customers_report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportTicketsPdf(array $filters)
    {
        $tickets = Ticket::with(['customer', 'staff'])
            ->filter($filters)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.tickets_pdf', [
            'tickets' => $tickets,
            'filters' => $filters,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('tickets_report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportInteractionsPdf(array $filters)
    {
        $interactions = Interaction::with(['customer', 'staff'])
            ->filter($filters)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.interactions_pdf', [
            'interactions' => $interactions,
            'filters' => $filters,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('interactions_report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportStaffsPdf(array $filters)
    {
        $staffs = User::where('role', 'R02')
            ->withCount(['interactions', 'tickets'])
            ->filter($filters)
            ->withTrashed()
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reports.staffs_pdf', [
            'staffs' => $staffs,
            'filters' => $filters,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('staffs_report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
