<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = ['open', 'resolved', 'in_progress', 'closed'];
        $priorities = ['low', 'medium', 'high'];

        $query = Ticket::query()
            ->whereHas('customer')
            ->whereHas('staff')
            ->latest();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $entries = request()->input('entries', 10);
        $filters = request()->only(['name', 'status', 'priority', 'start_date', 'end_date', 'staff']);

        $tickets = $query->filter($filters)->paginate($entries);

        // $tickets = Ticket::with(['customer', 'staff'])
        //     ->latest()
        //     ->paginate(10);

        return view('pages.tickets.index', compact(['tickets', 'statuses', 'priorities']));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        // $priorities = ['low', 'medium', 'high'];
        $staffs = User::where('role', 'R02')->get();

        return view('pages.tickets.create', compact('customers', 'staffs'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'staff_id' => ['required', 'exists:users,id'],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        //pass first to $validated['user_id']
        $validated['user_id'] = $validated['staff_id'];

        // dd($validated);

        Ticket::create([
            'user_id' => $validated['user_id'],
            'customer_id' => $request->customer_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open', // default
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['customer', 'staff']);

        return view('pages.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $customers = Customer::orderBy('name')->get();
        $staffs = User::where('role', 'R02')->orderBy('name')->get();
        // $priorities = ['low', 'medium', 'high'];
        // $statuses = ['open', 'in_progress', 'resolved', 'closed'];

        return view('pages.tickets.edit', compact('ticket', 'customers', 'staffs'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'staff_id' => ['required', 'exists:users,id'],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        //pass first to $validated['user_id']
        $validated['user_id'] = $validated['staff_id'];

        $ticket->update([
            'user_id' => $validated['user_id'],
            'customer_id' => $validated['customer_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Tickets deleted successfully.');
    }
}
