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
        Schema::table('supplies', function (Blueprint $blueprint) {
            // إضافة الأعمدة الجديدة
            
            // 1. العدد (يأتي بعد المبلغ)
            $blueprint->integer('quantity')->nullable()->after('amount');

            // 2. جهة التوريد (بنك/صندوق)
            $blueprint->string('deposit_location')->nullable()->after('receipt_number');

            // 3. نسبة التحويل وقيمتها المالية
            $blueprint->decimal('transfer_ratio', 5, 2)->default(0)->after('admin_ratio');
            $blueprint->decimal('transfer_value', 15, 2)->default(0)->after('admin_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplies', function (Blueprint $blueprint) {
            // لحذف الأعمدة في حال رغبت في التراجع
            $blueprint->dropColumn([
                'quantity', 
                'deposit_location', 
                'transfer_ratio', 
                'transfer_value'
            ]);
        });
    }
};