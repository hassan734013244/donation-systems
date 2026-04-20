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
    Schema::create('donor_reports', function (Blueprint $table) {
        $table->id('id_report'); // المعرف الأساسي
        
        // الربط مع المشاريع والمانحين
        // تأكد أن الجداول (projects, donors) تستخدم bigint في معرفاتها
        $table->foreignId('id_project')->constrained('projects', 'id_project')->onDelete('cascade');
        $table->foreignId('id_donor')->constrained('donors', 'id_donor')->onDelete('cascade');
        
        // إذا كنت تريد إضافة الربط مع التوريدات (الذي سبب الخطأ السابق) أضفه هنا:
        $table->foreignId('id_supply')->nullable()->constrained('supplies', 'id_supply')->onDelete('cascade');

        $table->string('report_title'); 
        $table->enum('report_type', ['financial', 'narrative', 'photos', 'final']); 
        $table->date('due_date'); 
        $table->enum('status', ['pending', 'submitted', 'overdue'])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}
};
