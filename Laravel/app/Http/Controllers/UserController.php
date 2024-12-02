<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // View all users (admin only)
    public function index()
    {    

         $this->authorize('admin-only');  // Only allow admins

        // Fetch all users
        $users = User::all();
        return response()->json($users);
    }

    // Assign role to user
    public function assignRole(Request $request, User $user)
    {
        $this->authorize('admin-only');  // Only allow admins

        $request->validate([
            'role' => 'required|string|in:Student,Instructor,Admin',  // Define allowed roles
        ]);

        // Assign the role
        $user->update(['role' => $request->role]);

        return response()->json(['message' => 'Role assigned successfully.']);
    }

    // Modify user role
    public function modifyRole(Request $request, User $user)
    {
        $this->authorize('admin-only');  // Only allow admins

        $request->validate([
            'role' => 'required|string|in:Student,Instructor,Admin',  // Define allowed roles
        ]);

        // Update the user's role
        $user->update(['role' => $request->role]);

        return response()->json(['message' => 'Role modified successfully.']);
    }

    // Delete user
    public function destroy(User $user)
    {
        $this->authorize('admin-only');  // Only allow admins

        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Suspend a user
    public function suspend(Request $request, User $user)
    {
        // Validate input data
        $request->validate([
            'reason' => 'required|string|max:255',
            'end_date' => 'nullable|date|after_or_equal:today',
        ]);

        // Update user suspension status
        $user->update([
            'is_suspended' => true,
            'suspension_reason' => $request->input('reason'),
            'suspension_start_date' => now(),
            'suspension_end_date' => $request->input('end_date'),
            // 'suspended_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'User suspended successfully']);
    }

    // Unsuspend a user
    public function unsuspend(User $user)
    {
        // Update user suspension status
        $user->update([
            'is_suspended' => false,
            'suspension_reason' => null,
            'suspension_start_date' => null,
            'suspension_end_date' => null,
            'suspended_by' => null,
        ]);

        return response()->json(['message' => 'User unsuspended successfully']);
    }
}
