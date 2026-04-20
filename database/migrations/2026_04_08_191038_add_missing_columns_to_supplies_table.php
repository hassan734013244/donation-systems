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
        // إضافة الحقل المفقود في الخطأ
        $table->text('statement')->nullable()->after('amount');
        
        // إضافة الحقول الأخرى التي ظهرت في الاستعلام لضمان عدم تكرار الخطأ
        if (!Schema::hasColumn('supplies', 'admin_value')) {
            $table->decimal('admin_value', 15, 2)->default(0);
        }
        if (!Schema::hasColumn('supplies', 'other_value')) {
            $table->decimal('other_value', 15, 2)->default(0);
        }
        if (!Schema::hasColumn('supplies', 'net_amount')) {
            $table->decimal('net_amount', 15, 2)->default(0);
        }
        if (!Schema::hasColumn('supplies', 'amount_base_currency')) {
            $table->decimal('amount_base_currency', 15, 2)->default(0);
        }
        if (!Schema::hasColumn('supplies', 'net_amount_base_currency')) {
            $table->decimal('net_amount_base_currency', 15, 2)->default(0);
        }
    });
}

public function down(): void
{
    Schema::table('supplies', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn(['statement', 'admin_value', 'other_value', 'net_amount', 'amount_base_currency', 'net_amount_base_currency']);
    });
}
};
