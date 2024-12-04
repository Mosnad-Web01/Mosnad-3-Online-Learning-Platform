<?php
namespace App\Providers;

use Illuminate\Support\Facades\Gate; // استيراد Gate
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // ضع سياساتك هنا إذا كانت موجودة
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {   
        // تعريف Gate للتحقق من صلاحية المستخدم
        Gate::define('admin-only', function ($user) {
            return strcasecmp($user->role, 'admin') === 0;
        });
    }
}
