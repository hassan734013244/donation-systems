<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // 1. تحديث تلقائي: أي تقرير تاريخه قديم وحالته "قيد الانتظار" اجعله "متأخر"
    \App\Models\DonorReport::where('status', 'pending')
        ->where('due_date', '<', now()->toDateString())
        ->update(['status' => 'overdue']);

    // 2. جلب التقارير المتأخرة
    $overdueReports = \App\Models\DonorReport::with('project')
        ->where('status', 'overdue')
        ->orderBy('due_date', 'asc')
        ->get();

    // 3. جلب التقارير التي موعدها خلال الـ 7 أيام القادمة
    $upcomingReports = \App\Models\DonorReport::with('project')
        ->where('status', 'pending')
        ->whereBetween('due_date', [now()->toDateString(), now()->addDays(7)->toDateString()])
        ->orderBy('due_date', 'asc')
        ->get();

        

    // 4. إرسال البيانات للواجهة
    return view('dashboard', compact('overdueReports', 'upcomingReports'));
}


}
