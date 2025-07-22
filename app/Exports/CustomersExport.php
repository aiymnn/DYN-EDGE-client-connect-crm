<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
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
        $customers = Customer::select(['id', 'name', 'id_number', 'email', 'phone', 'address', 'notes', 'created_at', 'deleted_at'])
            ->withCount(['interactions', 'tickets'])
            ->filter($this->filters ?? [])
            ->latest()
            ->get();

        return $customers->map(function ($customer) {
            return [
                // 'ID' => $customer->id,
                'Name' => $customer->name,
                // 'IC Number' => $customer->id_number,
                'Email' => $customer->email,
                'Phone' => $customer->phone,
                // 'Address' => $customer->address,
                // 'Notes' => $customer->notes,
                'Interactions Count' => $customer->interactions_count,
                'Tickets Count' => $customer->tickets_count,
                'Status' => $customer->deleted_at ? 'Inactive' : 'Active',
                'Registered At' => $customer->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            // 'ID',
            'Name',
            // 'IC Number',
            'Email',
            'Phone',
            // 'Address',
            // 'Notes',
            'Interactions Count',
            'Tickets Count',
            'Status',
            'Registered At',
        ];
    }
}
