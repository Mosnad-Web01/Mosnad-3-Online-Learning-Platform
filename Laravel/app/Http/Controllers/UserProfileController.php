<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function uploadImage(Request $request, $userId)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // البحث عن المستخدم في قاعدة البيانات
        $userProfile = UserProfile::findOrFail($userId);

        // التحقق من وجود صورة وتحميلها
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // تخزين الصورة في المجلد public/uploads داخل التخزين المحلي
            $path = $image->storeAs('uploads', $imageName, 'public');

            // حفظ المسار في قاعدة البيانات
            $userProfile->image = $path;
            $userProfile->save();

            return response()->json(['message' => 'تم رفع الصورة بنجاح!', 'imageUrl' => asset('storage/' . $path)]);
        }

        return response()->json(['message' => 'لم يتم رفع الصورة.'], 400);
    }


    /**
     * Display a listing of all UserProfiles.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
    
        if ($user) {
            $profile = $user->profile; // Assuming there's a one-to-one or hasOne relationship
            return response()->json($profile);
        }
    
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    
/**
 * Store a newly created UserProfile in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function store(Request $request)
{
    
    if (Auth::id() !== (int) $request->user_id) {
        return response()->json(['message' => 'Unauthorized action.'], 403);
    }
    

    // Validate request inputs
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'full_name' => 'nullable|string|max:255',
        'date_of_birth' => 'nullable|date',
        'address' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:20',
        'profile_picture' => 'nullable|string|max:255',
        'bio' => 'nullable|string'
    ]);

    // Create the UserProfile entry
    $profile = UserProfile::create($request->all());

    // Return success response
    return response()->json(['message' => 'UserProfile created successfully.', 'profile' => $profile], 201);
}

    /**
     * Display the specified UserProfile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * Update the specified UserProfile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * Remove the specified UserProfile from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
