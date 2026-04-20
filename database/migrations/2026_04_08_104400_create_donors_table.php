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
      Schema::create('donors', function (Blueprint $table) {
    $table->id('id_donor'); // معرف_المتبرع
    $table->string('donor_name'); // اسم_المتبرع
    $table->enum('donor_type', ['individual', 'organization', 'broker']); // نوع_المتبرع
    $table->string('phone')->nullable();
    $table->string('email')->nullable();
    $table->string('address')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
