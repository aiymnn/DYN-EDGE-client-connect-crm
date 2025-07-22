<?php

namespace App\Exports;

use App\Models\Interaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InteractionsExport implements FromCollection, WithHeadings
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
        $interactions = Interaction::query()
            ->with(['customer', 'staff'])
            ->filter($this->filters ?? [])
            ->latest()
            ->get();

        return $interactions->map(function ($interaction) {
            return [
                'ID' => $interaction->id,
                'Customer Name' => $interaction->customer->name ?? '-',
                'Staff Name' => $interaction->staff->name ?? '-',
                'Type' => ucfirst($interaction->type),
                'Notes' => $interaction->notes ?? '-',
                'Date & Time' => $interaction->datetime ? Carbon::parse($interaction->datetime)->format('d M Y, h:i A') : '-',
                'Created At' => $interaction->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Staff Name',
            'Type',
            'Notes',
            'Date & Time',
            'Created At',
        ];
    }
}
