<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public function index(Request $request)
{
    $query = DB::table('supplies')
        ->join('projects', 'supplies.id_project', '=', 'projects.id_project')
        ->join('currencies', 'supplies.id_currency', '=', 'currencies.id_currency')
        ->join('donors', 'supplies.id_donor', '=', 'donors.id_donor')
        ->leftJoin('departments', 'supplies.id_department', '=', 'departments.id_department')
        ->select(
            'projects.project_name', 
            'supplies.receipt_number',           
            'supplies.quantity',                 
            'supplies.net_amount', 
            'currencies.symbol as currency_symbol',             
            'supplies.supply_date',  
            'projects.start_date',
            'projects.end_date', 
            'departments.name_department',
            'donors.donor_name',
            'supplies.notes' 
        );

    // 1. الفلترة باسم المشروع
    if ($request->filled('project_search')) {
        $query->where('projects.project_name', 'like', '%' . $request->project_search . '%');
    }

    // 2. الفلترة برقم السند
    if ($request->filled('receipt_number')) {
        $query->where('supplies.receipt_number', $request->receipt_number);
    }

    // 3. الفلترة بالتاريخ (التوريدات بعد تاريخ معين)
    if ($request->filled('from_date')) {
        $query->whereDate('supplies.supply_date', '>=', $request->from_date);
    }

    $reports = $query->latest('supplies.supply_date')->paginate(12);

    // تأكد من تمرير البيانات للفلترة في الروابط (Pagination Links)
    $reports->appends($request->all());

    return view('media.index', compact('reports'));
}

public function publicShow($id)
{
    // 1. جلب السند مع كل علاقاته
    $supply = \App\Models\Supply::with(['project', 'currency', 'attachments', 'donor']) // أضفنا donor هنا
    ->where('id_supply', $id)
    ->firstOrFail();

    $reports = DB::table('donor_reports') // أو حسب اسم جدول التقارير عندك
    ->where('id_supply', $id)
    ->where('status', 'completed') // نجلب المكتملة فقط
    ->get();

    // 2. جلب عمليات الصرف المرتبطة بهذا السند (التي تظهر في الجدول الأسفل)
    $disbursements = DB::table('disbursements')
        ->where('id_supply', $id)
        ->get();

    // 3. الحساب الصحيح:
    // إجمالي ما تم صرفه "من هذا السند"
    $total_project_spent = $disbursements->sum('amount');

    // الرصيد المتبقي "في هذا السند"
    $remaining_balance = $supply->net_amount - $total_project_spent;

    return view('media.public_share', compact('supply', 'disbursements', 'total_project_spent', 'remaining_balance'));
}
}