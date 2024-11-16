<?php

// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->user() || auth()->user()->role !== $role) {
            // إذا لم يكن المستخدم لديه الدور المحدد، نقوم بإعادة التوجيه إلى صفحة غير مصرح بها
            return redirect('/');
        }

        return $next($request);
    }
}

