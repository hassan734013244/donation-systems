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
      Schema::create('funding_entities', function (Blueprint $table) {
    $table->id('id_entity'); // معرف_الجهة
    $table->string('entity_name'); // اسم_الجهة (مثلاً: بنك التضامن، خزينة المكتب)
    $table->enum('entity_type', ['bank', 'cash', 'exchange']); // نوع_الجهة
    $table->string('account_number')->nullable(); // رقم_الحساب
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funding_entities');
    }
};
