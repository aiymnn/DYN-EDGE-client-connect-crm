<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = ['call', 'email', 'meeting', 'whatsapp'];

        $query = Interaction::with('customer', 'staff')->latest();

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $entries = request()->input('entries', 10);
        $filters = request()->only(['name', 'type', 'start_date', 'end_date', 'staff']);

        $interactions = $query->filter($filters)->paginate($entries);

        // $interactions = Interaction::with('customer', 'staff')
        //     ->latest()
        //     ->paginate(10);

        // dd($interactions);

        return view('pages.interactions.index', [
            'interactions' => $interactions,
            'types' => $types,
        ]);
    }

    //custom method dropdown
    public function searchCustomers(Request $request)
    {
        $q = $request->get('q');

        $customers = Customer::query()
            ->where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($customers);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $types = ['call', 'email', 'meeting', 'whatsapp']; // boleh tambah jenis lain

        return view('pages.interactions.create', [
            'customers' => $customers,
            'staffs' => User::where('role', 'R02')->get(),
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'staff_id' => ['required', 'exists:users,id'],
            'type' => ['required', 'string'],
            'datetime' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        //pass first to $validated['user_id']
        $validated['user_id'] = $validated['staff_id'];

        // dd($validated);

        Interaction::create($validated);

        // $interaction = Interaction::create([
        //     'customer_id' => $validated['customer_id'],
        //     'user_id' => $validated['staff_id'],
        //     'type' => $validated['type'],
        //     'datetime' => $validated['datetime'],
        //     'notes' => $validated['notes'] ?? null,
        // ]);

        return redirect()
            ->route('interactions.index')
            ->with('success', 'Interaction created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Interaction $interaction)
    {
        $interaction->load(['customer', 'staff']);

        return view('pages.interactions.show', compact('interaction'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interaction $interaction)
    {
        $staffs = User::where('role', 'R02')->get();
        $customers = Customer::all();
        $types = ['call', 'email', 'meeting', 'urgent'];

        return view('pages.interactions.edit', compact('interaction', 'staffs', 'customers', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interaction $interaction)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'staff_id' => ['required', 'exists:users,id'],
            'type' => 'required|string',
            'datetime' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        //pass first to $validated['user_id']
        $validated['user_id'] = $validated['staff_id'];

        // dd($validated);

        $interaction->update($validated);

        return redirect()->route('interactions.index')->with('success', 'Interaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        $interaction->delete();

        return redirect()->route('interactions.index')->with('success', 'Interaction deleted successfully.');
    }
}
