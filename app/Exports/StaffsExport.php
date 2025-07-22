<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffsExport implements FromCollection, WithHeadings
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
        $staffs = User::where('role', 'R02')
            ->withCount(['interactions', 'tickets'])
            ->filter($this->filters ?? [])
            ->withTrashed()
            ->latest()
            ->get();

        return $staffs->map(function ($staff) {
            return [
                'ID' => $staff->id,
                'Name' => $staff->name,
                'Email' => $staff->email,
                'Phone' => $staff->phone,
                'Role' => $staff->role,
                'Total Interactions' => $staff->interactions_count,
                'Total Tickets' => $staff->tickets_count,
                'Status' => $staff->deleted_at ? 'Inactive' : 'Active',
                'Registered At' => $staff->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Role',
            'Total Interactions',
            'Total Tickets',
            'Status',
            'Registered At',
        ];
    }
}
