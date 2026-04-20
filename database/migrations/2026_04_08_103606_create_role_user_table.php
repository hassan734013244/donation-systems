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
    Schema::create('role_user', function (Blueprint $table) {
        $table->id();
        // لارافيل تبحث افتراضياً عن user_id لتربطه بجدول users
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // هنا حددنا id_role واسم الجدول roles لأنك استخدمت معرف غير افتراضي
        $table->foreignId('id_role')->constrained('roles', 'id_role')->onDelete('cascade');
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
