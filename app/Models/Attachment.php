<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    // تحديد المفتاح الأساسي لأنه ليس 'id' الافتراضي
    protected $primaryKey = 'id_attachment';

    protected $fillable = [
        'attachable_id', 
        'attachable_type', 
        'file_path', 
        'file_name', 
        'file_type'
    ];

    /**
     * الوصول إلى المودل الذي يمتلك المرفق (سواء كان توريد أو صرف)
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}