<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    public function adminOnly(User $user)
    {
        return $user->role === 'admin';
    }

    // تحديد ما إذا كان يمكن للمستخدم تحديث مستخدم آخر
    public function update(User $authUser, User $user)
    {
        return $authUser->role === 'admin' || $authUser->id === $user->id;
    }

    // تحديد ما إذا كان يمكن للمستخدم حذف مستخدم آخر
    public function delete(User $authUser, User $user)
    {
        return $authUser->role === 'admin';
    }
}
