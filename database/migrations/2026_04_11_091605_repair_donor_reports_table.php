<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('donor_reports', function (Blueprint $table) {
        // التأكد من إضافة العمود أولاً بنوع BigInteger Unsigned ليتوافق مع المعرفات الأساسية
        if (!Schema::hasColumn('donor_reports', 'id_supply')) {
            $table->unsignedBigInteger('id_supply')->nullable()->after('id_donor');
        }

        // الربط الاحترافي:
        // نربط id_supply بجدول supplies 
        // ونخبره صراحة أن المفتاح الأساسي في ذلك الجدول هو 'id_supply'
        $table->foreign('id_supply')
              ->references('id_supply') // تأكد أن هذا هو الاسم في جدول supplies
              ->on('supplies')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('donor_reports', function (Blueprint $table) {
        $table->dropForeign(['id_supply']);
        $table->dropColumn('id_supply');
    });
}
};
