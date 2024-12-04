<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class _AdminUserController extends Controller
{
    public function showUsers()
{
    
        $users = \App\Models\User::all();

        return view('admin.admin-user', compact('users'));
 
}


    public function updateUsers(Request $request)
    {
        // التأكد من صحة البيانات القادمة من النموذج
        $request->validate([
            'users' => 'required|array',
            'users.*.id' => 'required|integer|exists:users,id',
            'users.*.role' => 'required|string|in:Student,Instructor,Admin',
        ]);

        // إرسال التحديثات إلى API
        foreach ($request->users as $user) {
            Http::post(route('api.users.modify-role', ['user' => $user['id']]), [
                'role' => $user['role'],
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Users updated successfully!');
    }
}
