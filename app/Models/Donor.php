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

public function reports()
{
    return $this->hasMany(DonorReport::class, 'id_donor'); // أو id_donor
}
}
