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
Schema::create('supplies', function (Blueprint $table) {
    $table->id('id_supply');
    
    // الربط بالجداول الأساسية
    $table->foreignId('id_project')->constrained('projects', 'id_project');
    $table->foreignId('id_donor')->constrained('donors', 'id_donor');
    $table->foreignId('id_entity')->constrained('funding_entities', 'id_entity');
    $table->foreignId('id_currency')->constrained('currencies', 'id_currency');

    // البيانات المالية
    $table->decimal('amount', 18, 2); // المبلغ الأصلي
    $table->decimal('admin_ratio', 5, 2)->default(0); // نسبة الإدارة (مثلاً 10.00)
    $table->decimal('other_ratio', 5, 2)->default(0); // نسبة أخرى
    $table->decimal('admin_value', 18, 2)->default(0); // قيمة النسبة الإدارية
    $table->decimal('other_value', 18, 2)->default(0); // قيمة النسبة الأخرى
    $table->decimal('net_amount', 18, 2); // صافي المبلغ

    // بيانات العملات والصرف
    $table->decimal('exchange_rate', 18, 6)->default(1);
    $table->decimal('amount_base_currency', 18, 2); // المبلغ بالعملة الأساسية
    $table->decimal('net_amount_base_currency', 18, 2); // الصافي بالعملة الأساسية

    // بيانات إضافية
    $table->string('receipt_number')->unique(); // رقم السند
    $table->date('supply_date');
    $table->text('notes')->nullable();
    $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
