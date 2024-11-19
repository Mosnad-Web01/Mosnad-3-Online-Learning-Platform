<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    public function show()
    {
        // جلب المستخدم الحالي بناءً على المصادقة
        $user = Auth::user();

        // التأكد من أن المستخدم مسجل الدخول
        if ($user) {
            // جلب بيانات الملف الشخصي للمستخدم
            $profile = $user->profile;

            // التحقق إذا كان الملف الشخصي موجودًا
            if ($profile) {
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'profile' => $profile
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User profile not found'
                ], 404);
            }
        }

        // في حالة عدم وجود مستخدم مسجل الدخول
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ], 401);
    }
}
