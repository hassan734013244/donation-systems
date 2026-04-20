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
    Schema::table('supplies', function (Illuminate\Database\Schema\Blueprint $table) {
        // تعديل الحقل ليقبل القيمة الفارغة
        $table->unsignedBigInteger('id_entity')->nullable()->change();
    });
}

public function down(): void
{
    Schema::table('supplies', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->unsignedBigInteger('id_entity')->nullable(false)->change();
    });
}
};
