<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'id_role';
    
    protected $guarded = [];
   public function permissions()
{
    // الدور يملك عدة صلاحيات عبر الجدول الوسيط permission_role
    return $this->belongsToMany(Permission::class, 'permission_role', 'id_role', 'id_permission');
}

public function users()
{
    return $this->belongsToMany(User::class, 'role_user', 'id_role', 'user_id');

}
}
