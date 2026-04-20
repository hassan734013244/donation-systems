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
        Schema::table('currencies', function (Illuminate\Database\Schema\Blueprint $table) {
        // إضافة عمود سعر الصرف مع قيمة افتراضية لتجنب المشاكل
        $table->decimal('exchange_rate', 15, 2)->default(1.00)->after('currency_code');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('currencies', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn('exchange_rate');
    });
    }
};
