<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * عرض جميع الـ UserProfiles.
     */
    public function index()
    {
        $profiles = UserProfile::all();
        return response()->json($profiles);
    }

    /**
     * إضافة UserProfile جديد.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'full_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|string|max:255',
            'bio' => 'nullable|string'
        ]);

        $profile = UserProfile::create($request->all());

        return response()->json(['message' => 'UserProfile created successfully.', 'profile' => $profile], 201);
    }

    /**
     * عرض بيانات UserProfile محدد.
     */
    public function show($id)
    {
        $profile = UserProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'UserProfile not found.'], 404);
        }

        return response()->json($profile);
    }

    /**
     * تحديث بيانات UserProfile محدد.
     */
    public function update(Request $request, $id)
    {
        $profile = UserProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'UserProfile not found.'], 404);
        }

        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|string|max:255',
            'bio' => 'nullable|string'
        ]);

        $profile->update($request->all());

        return response()->json(['message' => 'UserProfile updated successfully.', 'profile' => $profile]);
    }

    /**
     * حذف UserProfile محدد.
     */
    public function destroy($id)
    {
        $profile = UserProfile::find($id);

        if (!$profile) {
            return response()->json(['message' => 'UserProfile not found.'], 404);
        }

        $profile->delete();

        return response()->json(['message' => 'UserProfile deleted successfully.']);
    }
}
