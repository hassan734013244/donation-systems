<?php

namespace App\Observers;

use App\Models\Supply;

class SupplyObserver
{
    /**
     * Handle the Supply "created" event.
     */
    public function created(Supply $supply): void
    {
        //
    }

    /**
     * Handle the Supply "updated" event.
     */
    public function updated(Supply $supply): void
    {
        //
    }

    /**
     * Handle the Supply "deleted" event.
     */
    public function deleted(Supply $supply): void
    {
        //
    }

    /**
     * Handle the Supply "restored" event.
     */
    public function restored(Supply $supply): void
    {
        //
    }

    /**
     * Handle the Supply "force deleted" event.
     */
    public function forceDeleted(Supply $supply): void
    {
        //
    }

    public function creating(Supply $supply)
{
    // 1. حساب القيم من النسب
    $supply->admin_value = ($supply->amount * $supply->admin_ratio) / 100;
    $supply->other_value = ($supply->amount * $supply->other_ratio) / 100;

    // 2. حساب الصافي
    $supply->net_amount = $supply->amount - ($supply->admin_value + $supply->other_value);

    // 3. التحويل للعملة الأساسية (بناءً على سعر الصرف المدخل)
    $supply->amount_base_currency = $supply->amount * $supply->exchange_rate;
    $supply->net_amount_base_currency = $supply->net_amount * $supply->exchange_rate;
}
}
