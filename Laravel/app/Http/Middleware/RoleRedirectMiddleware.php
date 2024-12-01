<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$rolesAndPaths
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, ...$rolesAndPaths)
    {
        // تأكد من أن المستخدم مسجل دخول
        if (Auth::check()) {
            $user = Auth::user(); // المستخدم الحالي

            // تحميل العلاقة مع الأدوار إذا لم تكن محملة مسبقًا
            // $user->load('roles');

            // جلب أسماء الأدوار الخاصة بالمستخدم
            $userRoles = $user->roles->pluck('name')->toArray();
 // تحقق إذا كان المستخدم لا يمتلك أي أدوار
 if (empty($userRoles)) {
    return redirect('/dashboard'); // أو أي مسار افتراضي
}

            // تحقق من الأدوار المرسلة للميدلوير
            for ($i = 0; $i < count($rolesAndPaths); $i += 2) {
                $role = $rolesAndPaths[$i];
                $path = $rolesAndPaths[$i + 1] ?? null;

                // تحقق من تطابق الأدوار مع المستخدم
                if (in_array($role, $userRoles) && $path) {
                    return redirect($path); // توجيه حسب الدور
                }
            }

            // إذا لم يتطابق أي دور، قم بإرجاع استجابة أو توجيه افتراضي
            return redirect('/dashboard');
        }

        // إذا لم يكن مسجل دخول
        return redirect('/login');
    }
}
