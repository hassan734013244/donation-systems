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
    // 1. إنشاء جدول المستخدمين من الصفر
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');

        // الربط مع جدول الإدارات أو الفروع
        // ملاحظة: تأكد أن جدول departments أو branches تم إنشاؤه قبل هذا الجدول
        $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');

        // تحديد دور المستخدم (مدير عام، مدير إدارة، موظف)
        $table->enum('role', ['admin', 'manager', 'user'])->default('user');

        // حالة الحساب
        $table->enum('status', ['active', 'inactive'])->default('active');

        $table->rememberToken();
        $table->timestamps();
    });

    // 2. إنشاء جدول استعادة كلمة المرور
    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    // 3. إنشاء جدول الجلسات (Sessions)
    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}
};