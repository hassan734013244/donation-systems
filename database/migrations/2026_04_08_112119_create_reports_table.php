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
    Schema::create('reports', function (Blueprint $table) {
        $table->id('id_report'); // معرف_التقرير
        
        // ربط التقرير بعملية توريد معينة (Foreign Key)
        $table->foreignId('id_supply')->constrained('supplies', 'id_supply')->onDelete('cascade');
        
        $table->string('report_type'); // نوع_التقرير (مثلاً: تقرير مالي، تقرير إنجاز)
        $table->string('status');      // حالة_التقرير (مثلاً: تم التصدير، قيد المعالجة)
        $table->text('notes')->nullable(); // ملاحظات
        
        $table->timestamps(); // تاريخ_الإنشاء وتاريخ_التحديث
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
