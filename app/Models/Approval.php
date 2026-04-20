<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'approvals';

    // الحقول المسموح بحفظها جماعياً (Mass Assignment)
    protected $fillable = [
        'id_supply',      // هذا هو الحقل الذي يسبب الخطأ حالياً
        'user_id',
        'role_name',
        'status',
        'approval_date',
        'notes',
    ];

    /**
     * العلاقة مع موديل التوريد (Supply)
     */
    public function supply()
    {
        return $this->belongsTo(Supply::class, 'id_supply', 'id_supply');
    }
}