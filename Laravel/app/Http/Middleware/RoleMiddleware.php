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
            return response(
                "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Unauthorized</title>
                    <style>
                        body { font-family: Arial, sans-serif; background-color: #e0f7fa; color: #00796b; text-align: center; padding: 50px; }
                        h1 { font-size: 2rem; color: #004d40; }
                        p { font-size: 1rem; }
                    </style>
                </head>
                <body>
                    <h1>Unauthorized</h1>
                    <p>You must be logged in to access this page.</p>
                </body>
                </html>",
                401
            );
        }

        // الحصول على المستخدم الحالي
        $user = Auth::user();

        // إذا كان الحقل 'role' يحتوي على أكثر من دور مفصول بفواصل
        $userRoles = explode(',', $user->role); // تحويل إلى مصفوفة
        // التحقق من أن أي دور من أدوار المستخدم يتطابق مع الأدوار المسموح بها
        if (!array_intersect($roles, $userRoles)) {
            return response(
                "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Forbidden</title>
                    <style>
                        body { font-family: Arial, sans-serif; background-color: #e0f7fa; color: #00796b; text-align: center; padding: 50px; }
                        h1 { font-size: 2rem; color: #004d40; }
                        p { font-size: 1rem; }
                    </style>
                </head>
                <body>
                    <h1>Error: Page Not Found</h1>
                </body>
                </html>",
                403
            );
        }

        return $next($request);
    }
}
