<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
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

    /**
     * عرض نموذج إنشاء ملف شخصي جديد.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create'); // عرض نموذج إضافة ملف شخصي جديد
    }

    /**
     * حفظ البيانات المدخلة من المستخدم وإنشاء ملف شخصي جديد.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
            'bio' => 'nullable|string',
        ]);

        // إنشاء الملف الشخصي
        $profile = new UserProfile([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'bio' => $request->bio,
        ]);

        // رفع الصورة الشخصية إذا كانت موجودة
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;
        }

        $profile->save();

        return redirect()->route('profile.show', $profile->id)->with('success', 'Profile created successfully!');
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
     * تحديث البيانات المدخلة للملف الشخصي.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
            'bio' => 'nullable|string',
        ]);

        $profile = UserProfile::findOrFail($id);
        $profile->update([
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'bio' => $request->bio,
        ]);

        // رفع صورة الملف الشخصي إذا كانت موجودة
        if ($request->hasFile('profile_picture')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($profile->profile_picture) {
                Storage::delete('public/' . $profile->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;
        }

        $profile->save();

        return redirect()->route('profile.show', $profile->id)->with('success', 'Profile updated successfully!');
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
