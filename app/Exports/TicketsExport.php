<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $tickets = Ticket::with(['customer', 'staff'])
            ->filter($this->filters ?? [])
            ->latest()
            ->get();

        return $tickets->map(function ($ticket) {
            return [
                'ID' => $ticket->id,
                'Title' => $ticket->title,
                'Customer Name' => $ticket->customer->name ?? '-',
                'Staff Name' => $ticket->staff->name ?? '-',
                'Status' => ucfirst(str_replace('_', ' ', $ticket->status)),
                'Priority' => ucfirst($ticket->priority),
                'Created At' => $ticket->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Customer Name',
            'Staff Name',
            'Status',
            'Priority',
            'Created At',
        ];
    }
}
