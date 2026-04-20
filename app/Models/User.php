<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// تحديث الحقول المسموح بتعبئتها لتشمل القسم والدور
#[Fillable(['name', 'email', 'password', 'id_department', 'id_role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * علاقة المستخدم بالإدارة
     * كل مستخدم ينتمي لإدارة واحدة
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'id_department');
        //return $this->belongsTo(Department::class);
    }

    /**
     * علاقة المستخدم بالصلاحيات (Roles)
     * ملاحظة: تأكد أن جدول الأدوار يحتوي على id_role كفتاح أساسي
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'id_role');
    }

    /**
     * دالة مساعدة للتحقق مما إذا كان المستخدم لديه دور معين
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('role_name', $roleName)->exists();
    }
}