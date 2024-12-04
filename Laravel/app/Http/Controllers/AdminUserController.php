<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = User::query();

    if ($request->has('search') && $request->search) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('email', 'like', '%' . $searchTerm . '%')
              ->orWhere('role', 'like', '%' . $searchTerm . '%');
        });
    }

    $users = $query->paginate(10);  // إرجاع النتائج مع التصفية بناءً على البحث
    return view('admin.users.index', compact('users'));
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
        // Conditionally require fields based on the value of is_suspended
        'suspension_reason' => 'required_if:is_suspended,true|string|max:255', // Only required if is_suspended is true
        'end_date' => 'required_if:is_suspended,true|date|after:today', // Only required if is_suspended is true
        'role' => 'required|in:admin,student,instructor', // Ensure role is one of the valid options

    ]);
    
    // Manually set the boolean value based on the checkbox
    $isSuspended = filter_var($request->input('is_suspended'), FILTER_VALIDATE_BOOLEAN);
    
    // Update user data based on validated input
    $user->update([
        'is_suspended' => $isSuspended, // Save boolean value
        'suspension_reason' => $request->input('suspension_reason'), // Use validated data
        'suspension_start_date' => now(),
        'suspension_end_date' => $request->input('end_date'), // Use validated data
         'suspended_by' => auth()->id(), // Optionally include the user who suspended
         'role' => $request->input('role'), // Add role field to the update

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
