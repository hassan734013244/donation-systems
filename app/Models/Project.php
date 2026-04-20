<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // تحديد اسم المفتاح الأساسي المخصص
    protected $primaryKey = 'id_project';

    // السماح بالإدخال الجماعي لهذه الأعمدة
    protected $fillable = [
        'project_name',
        'status',
        'start_date',
        'end_date',
    ];

    // إذا كنت تفضل فتح الإدخال لكل الأعمدة (طريقة بديلة وأسرع)
    // protected $guarded = []; 

    public function reports()
{
    return $this->hasMany(DonorReport::class, 'id_project'); // أو id_donor
}
}