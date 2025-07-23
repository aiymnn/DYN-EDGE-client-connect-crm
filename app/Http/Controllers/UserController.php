<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entries = request()->input('entries', 10); // default 10
        $filters = request()->only(['name', 'email', 'phone']);

        $staffs = User::where('role', 'R02')->select(['id', 'name', 'email', 'phone', 'deleted_at'])
            ->filter($filters)
            ->latest()
            ->withTrashed()
            ->paginate($entries)
            ->withQueryString();

        return view('pages.staffs.index', [
            'staffs' => $staffs,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.staffs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'role' => 'required|in:R01,R02',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'Staff created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        $staff = User::withTrashed()
            ->select(['id', 'name', 'email', 'phone', 'role', 'created_at', 'deleted_at'])
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
            ->findOrFail($user);

        return view('pages.staffs.show', compact('staff'));

        // dd($staff);

        return view('pages.staffs.show', compact('staff'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $staff = User::findOrFail($user->id);
        return view('pages.staffs.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'role' => 'required|in:R01,R02',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Staff updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Staff deleted successfully.');
    }

    public function restore($user)
    {
        $user = User::withTrashed()->findOrFail($user);

        if ($user->trashed()) {
            $user->restore();
            return redirect()->route('users.show', $user->id)->with('success', 'User account has been activated.');
        }

        return redirect()->route('users.show', $user->id)->with('info', 'User account is already active.');
    }
}
