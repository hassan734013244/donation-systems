<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $primaryKey = 'id_currency';
    
    protected $fillable = [
        'currency_name', // ريال يمني، دولار...
        'currency_code', // YER, USD, SAR
        'exchange_rate', // سعر الصرف مقابل العملة الأساسية
    ];
}
