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
        Schema::create('approvals', function (Blueprint $table) {
    $table->id('id_approval');
    
    // ربط الاعتماد بعملية توريد محددة
    $table->foreignId('id_supply')->constrained('supplies', 'id_supply')->onDelete('cascade');
    
    // ربط الاعتماد بالمستخدم الذي قام بالعملية
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    
    // الدور الذي قام بالاعتماد (مثلاً: مدير مالي، مدير فرع)
    $table->string('role_name'); 
    
    // حالة الاعتماد
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    
    $table->date('approval_date');
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
