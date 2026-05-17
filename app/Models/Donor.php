<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
   protected $primaryKey = 'id_donor';

protected $fillable = [
    'donor_name',
    'donor_type',
];


public function supplies()
{
    // المتبرع الواحد لديه العديد من التوريدات
    // الحقل الوسيط في جدول التوريدات هو id_donor
    return $this->hasMany(Supply::class, 'id_donor', 'id_donor');
}

public function reports()
{
    return $this->hasMany(DonorReport::class, 'id_donor'); // أو id_donor
}
}
