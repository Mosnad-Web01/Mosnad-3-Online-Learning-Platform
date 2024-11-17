<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottle extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|string  ...$parameters
     * @return mixed
     */
    public function handle($request, Closure $next, ...$parameters)
    {
        // يمكنك تخصيص منطق التحكم في معدل الطلبات هنا
        // تأكد من استخدام التوقيع الصحيح للدالة
        return parent::handle($request, $next, ...$parameters);
    }
}
