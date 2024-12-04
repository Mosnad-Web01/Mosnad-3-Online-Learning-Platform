<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // التحقق من أن المستخدم مصادق عليه
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // الحصول على المستخدم الحالي
        $user = Auth::user();
    
        // إذا كان الحقل 'role' يحتوي على أكثر من دور مفصول بفواصل
        $userRoles = explode(',', $user->role); // تحويل إلى مصفوفة
        // التحقق من أن أي دور من أدوار المستخدم يتطابق مع الأدوار المسموح بها
        if (!array_intersect($roles, $userRoles)) {
            return response()->json(['message' => 'Forbidden: You do not have the required role'], 403);
        }
    
        return $next($request);
    }
    
}
