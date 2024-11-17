<?php


// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // جلب قائمة المستخدمين (للمشرف فقط)
    public function index()
    {
        $this->authorize('admin-only');
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
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json($user);
    }

    // حذف مستخدم
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
