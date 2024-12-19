<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebProfileController extends Controller
{
    /**
     * عرض ملف المستخدم الشخصي.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();  // جلب المستخدم الحالي
        $profile = $user->profile;  // جلب الملف الشخصي للمستخدم

        return view('profile.show', compact('profile'));
    }
    public function showForm()
    {
        // جلب ملف المستخدم الحالي إذا كان موجودًا
        $profile = Auth::user()->profile; // حسب العلاقة بين المستخدم والبروفايل
        return view('profile.form', compact('profile'));
    }
    /**
     * عرض نموذج إنشاء ملف شخصي جديد.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $user = Auth::user(); // Get the logged-in user

        // // Check if the user already has a profile
        // if ($user->profile) {
        //     return redirect()->route('profile.show', $user->profile->id)->with('error', 'You already have a profile.');
        // }
    
 // جلب الملف الشخصي للمستخدم الحالي
 $profile = $user->profile;

 // عرض نفس النموذج مع تمرير البيانات إذا كانت موجودة
 return view('profile.form', compact('profile'));    }

    /**
     * حفظ البيانات المدخلة من المستخدم وإنشاء ملف شخصي جديد.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Httpد\Response
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cover_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = Auth::user()->profile()->create($validated);

        if ($request->hasFile('profile_picture')) {
            $profile->update(['profile_picture' => $request->file('profile_picture')->store('profiles')]);
        }

        if ($request->hasFile('cover_picture')) {
            $profile->update(['cover_picture' => $request->file('cover_picture')->store('covers')]);
        }

        return redirect()->route('profile.form')->with('success', 'Profile created successfully.');
    }
    /**
     * تحديث البيانات المدخلة للملف الشخصي.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $profile = Auth::user()->profile;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cover_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile->update($validated);

        if ($request->hasFile('profile_picture')) {
            $profile->update(['profile_picture' => $request->file('profile_picture')->store('profiles')]);
        }

        if ($request->hasFile('cover_picture')) {
            $profile->update(['cover_picture' => $request->file('cover_picture')->store('covers')]);
        }

        return redirect()->route('profile.form')->with('success', 'Profile updated successfully.');
    }

    /**
     * عرض نموذج تحرير الملف الشخصي.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = UserProfile::findOrFail($id);
        return view('profile.edit', compact('profile'));
    }

    /**
     * حذف الملف الشخصي.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = UserProfile::findOrFail($id);

        // حذف الصورة القديمة إذا كانت موجودة
        if ($profile->profile_picture) {
            Storage::delete('public/' . $profile->profile_picture);
        }

        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully!');
    }
}
