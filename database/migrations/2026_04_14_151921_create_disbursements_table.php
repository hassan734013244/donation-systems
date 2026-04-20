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
    Schema::create('disbursements', function (Blueprint $table) {
        $table->id_disbursement(); // أو $table->id_disbursement حسب رغبتك
        $table->unsignedBigInteger('id_supply'); // الربط مع سند التوريد
        $table->double('amount', 15, 2);         // مبلغ الصرف
        $table->date('disbursement_date')->nullable();
        $table->timestamps();

        // ربط مفتاح خارجي بجدول التوريدات
        $table->foreign('id_supply', 'fk_disbursements_supply_unique')
      ->references('id_supply')
      ->on('supplies')
      ->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disbursements');
    }
};
