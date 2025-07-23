<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = request()->input('entries', 10); // default 10
        $filters = request()->only(['name', 'email', 'phone']);

        $customers = Customer::withTrashed()
            ->select(['id', 'name', 'email', 'phone', 'deleted_at'])
            // ->withCount(['interactions', 'tickets'])
            ->filter($filters)
            ->latest()
            ->paginate($entries)
            ->withQueryString();

        return view('pages.customers.index', [
            'customers' => $customers,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:customers,name',
            'id_number' => 'required|string|max:50|unique:customers,id_number',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($customer)
    {
        $customer = Customer::withTrashed()
            ->select(['id', 'name', 'id_number', 'address', 'email', 'phone', 'notes', 'created_at', 'deleted_at'])
            ->withCount([
                'interactions',
                'tickets',
                'tickets as open_tickets_count' => function ($query) {
                    $query->where('status', 'open');
                },
                'tickets as in_progress_tickets_count' => function ($query) {
                    $query->where('status', 'in_progress');
                },
                'tickets as resolved_tickets_count' => function ($query) {
                    $query->where('status', 'resolved');
                },
                'tickets as closed_tickets_count' => function ($query) {
                    $query->where('status', 'closed');
                },
            ])
            ->findOrFail($customer);

        // dd($customer);

        return view('pages.customers.show', [
            'customer' => $customer,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('pages.customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:customers,name,' . $customer->id,
            'id_number' => 'required|string|max:50|unique:customers,id_number,' . $customer->id,
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function restore($customer)
    {
        $customer = Customer::withTrashed()->findOrFail($customer);

        if ($customer->trashed()) {
            $customer->restore();
            return redirect()->route('customers.show', $customer->id)->with('success', 'customer account has been activated.');
        }

        return redirect()->route('customers.show', $customer->id)->with('success', 'Customer account is already active.');
    }
}
