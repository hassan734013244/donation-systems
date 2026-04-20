<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Supply::observe(\App\Observers\SupplyObserver::class);

        // تعريف بوابة المدير
    Gate::define('is-admin', function (User $user) {
        // نتحقق من الدور المرتبط بالمستخدم
        return $user->roles()->where('role_name', 'مدير النظام')->exists();
    });

    Gate::define('manage-system', function ($user) {
        return $user->role === 'admin';
    });

    // تعريف بوابة للموظف والمدير (مثلاً لرفع التقارير)
    Gate::define('submit-reports', function ($user) {
        return in_array($user->role, ['admin', 'user']);
    });
     Gate::define('access-media', function ($user) {
        return $user->department?->name_department === 'الإعلام' || $user->department?->id_department === null;
    });
    Gate::define('admin', function ($user) {
        return $user->department?->id_department === null;
    });

     Gate::define('sci', function ($user) {
        return $user->department?->name_department === 'الإدارة العلمية' || $user->department?->id_department === null || $user->department?->name_department === 'التعليم عن بعد';
    });
    }

   
}
