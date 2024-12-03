<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // جلب كل المستخدمين
        return view('admin.users.index', compact('users')); // عرض صفحة قائمة المستخدمين
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create'); // عرض صفحة إنشاء مستخدم جديد
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user')); // عرض صفحة تفاصيل المستخدم
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user')); // عرض صفحة تعديل مستخدم معين
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'reason' => 'required|string|max:255', // Reason is required and should be a string with a maximum length of 255 characters
        'end_date' => 'required|date|after:today', // End date is required and must be a date after today
        'is_suspended' => 'nullable|boolean', // Optional boolean field to indicate suspension status
    ]);

    // Update user data based on the validated input
    $user->update([
        'is_suspended' => $request->has('is_suspended') ? $request->input('is_suspended') : $user->is_suspended, // Check if 'is_suspended' is provided, otherwise keep the current value
        'suspension_reason' => $validated['reason'], // Use validated data
        'suspension_start_date' => now(),
        'suspension_end_date' => $validated['end_date'], // Use validated data
        //  'suspended_by' => auth()->id(), // Optionally include the user who suspended
    ]);

    return redirect()->route('users.index')
        ->with('success', 'User updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
