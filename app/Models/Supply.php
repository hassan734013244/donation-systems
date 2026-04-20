<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{


    protected $primaryKey = 'id_supply';
    protected $fillable = [
    'id_project', 'id_donor','id_supply', 'id_department','id_entity', 'id_currency', 'amount', 'statement',
    'admin_ratio', 'other_ratio', 'admin_value', 'other_value', 'net_amount',
    'exchange_rate', 'amount_base_currency', 'net_amount_base_currency',
    'receipt_number', 'supply_date', 'notes', 'status' ,'quantity','rejection_reason', 'deposit_location', 'transfer_ratio', 'transfer_value'
];
    // علاقة التوريد بالمشروع
    public function project() {
        return $this->belongsTo(Project::class, 'id_project');
    }

    // علاقة التوريد بالمتبرع
    public function donor() {
        return $this->belongsTo(Donor::class, 'id_donor');
    }

    // علاقة التوريد بالعملة
    public function currency() {
        return $this->belongsTo(Currency::class, 'id_currency');
    }

    public function requiredReport()
{
    return $this->belongsTo(DonorReport::class, 'id_report');
}
public function reports(){
    return $this->hasMany(DonorReport::class, 'id_supply', 'id_supply');
}

// علاقة المرفقات (Polymorphic)
    public function attachments() {
        return $this->morphMany(Attachment::class, 'attachable');
    }



public function department()
{
    return $this->belongsTo(Department::class, 'id_department', 'id_department');
}




}