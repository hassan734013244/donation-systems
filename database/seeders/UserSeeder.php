<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على أول فرع تم إنشاؤه في BasicDataSeeder
        $branch = Branch::first();

        // التأكد من وجود فرع لتجنب الأخطاء
        if ($branch) {
            // 1. إنشاء دور "مدير نظام"
            $adminRole = Role::create([
                'role_name' => 'مدير النظام',
                'description' => 'صلاحيات كاملة على النظام'
            ]);

            // 2. إنشاء مستخدم مسؤول
            $user = User::create([
                'name' => 'أحمد المسؤول',
                'email' => 'admin@system.com',
                'password' => bcrypt('123456'), // كلمة المرور
                'id_branch' => $branch->id_branch,
                'status' => 'active'
            ]);

            // 3. ربط المستخدم بالدور (عبر الجدول الوسيط role_user)
            // نستخدم id_role لأنك حددته كمفتاح أساسي في المايجريشن
            $user->roles()->attach($adminRole->id_role);
        }
    }
}