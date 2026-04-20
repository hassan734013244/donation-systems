<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorReport extends Model
{
    use HasFactory;

    // تحديد المفتاح الأساسي ليطابق قاعدة البيانات
    protected $primaryKey = 'id_report';

    // إضافة الحقول المسموح بتعبئتها تلقائياً
    protected $fillable = [
        'id_project',
        'id_donor',
        'id_supply',
        'report_title',
        'report_type',
        'due_date',
        'status',
        'notes',
        'report_file'      // ضروري جداً لحفظ مسار ملف التقرير المرفوع
       
    ];

    // علاقة التقرير بالمشروع
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }

    // علاقة التقرير بالمتبرع
    public function donor()
    {
        return $this->belongsTo(Donor::class, 'id_donor', 'id_donor');
    }

    // علاقة التقرير بسند التوريد
    public function supply()
    {
        return $this->belongsTo(Supply::class, 'id_supply', 'id_supply');
    }

 
}