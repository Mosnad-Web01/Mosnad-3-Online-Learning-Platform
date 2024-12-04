<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    // جلب قائمة المستخدمين (للمشرف فقط)
    public function index()
    {
        $this->authorize('admin-only'); // التأكد من أن المستخدم هو الأدمن
        $users = User::all();
        return response()->json($users);
    }


    // جلب معلومات مستخدم محدد
    // جلب معلومات المستخدم بناءً على التوكن
    public function show(Request $request)
    {
        return response()->json($request->user());
    }


    // تحديث معلومات مستخدم
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // التأكد من أن المستخدم الذي يعدل هو الأدمن أو هو نفس المستخدم
        $this->authorize('update-user', $user);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'role' => 'sometimes|in:student,instructor,admin', // إضافة التحقق من الدور
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role, // تحديث الدور
        ]);

        return response()->json($user);
    }


    // حذف مستخدم
    public function destroy($id)
{
    $user = User::findOrFail($id);

    // التأكد من أن المستخدم الذي يحذف هو الأدمن أو هو نفس المستخدم
    $this->authorize('delete-user', $user);

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}

}
