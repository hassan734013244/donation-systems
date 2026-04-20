<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
    $table->id('id_attachment');
    $table->morphs('attachable'); // يسمح بربط المرفق بسند توريد أو صرف (PolyMorphic)
    $table->string('file_path');  // مسار الملف في السيرفر
    $table->string('file_name');  // الاسم الأصلي للملف
    $table->string('file_type');  // نوع الملف (image, video, pdf)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
