<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'id_department';
    
    protected $fillable = ['name_department'];

    /**
     * علاقة الإدارة بالمستخدمين
     * كل إدارة لديها العديد من المستخدمين
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_department', 'id_department');
    }
    // داخل كلاس Department
    public function supplies()
     {
    // الربط بين id_department في جدول الإدارات و id_department في جدول السندات
    return $this->hasMany(\App\Models\Supply::class, 'id_department', 'id_department');
      }

    
}
