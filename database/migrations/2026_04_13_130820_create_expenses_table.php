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
       Schema::create('expenses', function (Blueprint $table) {
    $table->id('id_expense');
    $table->foreignId('id_supply')->constrained('supplies', 'id_supply'); // الصرف يتم من أي توريد؟
    $table->foreignId('id_user')->constrained('users'); // من الذي قام بالصرف؟
    $table->decimal('amount', 15, 2); 
    $table->string('statement'); // بيان الصرف (لماذا صرف هذا المبلغ؟)
    $table->date('expense_date');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
