<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use App\Models\Project;
use App\Models\Donor;
use App\Models\FundingEntity;
use App\Models\Currency;
use App\Models\DonorReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    // عرض صفحة إضافة توريد جديد
    public function create()
    {
        $projects = Project::where('status', 'active')->get(); 
        $donors = Donor::all();
        $currencies = Currency::all();
        $departments = DB::table('departments')->get();

        return view('supplies.create', compact('projects', 'donors', 'currencies' ,'departments'));
    }

    // حفظ البيانات في قاعدة البيانات
    public function store(Request $request)
{
    // 1. التحقق من البيانات (بما في ذلك المرفقات)
    $validated = $request->validate([
        'id_project'      => 'required',
        'id_donor'        => 'required',
        'id_currency'     => 'required',
        'id_department' => 'required|exists:departments,id_department',
        'amount'          => 'required|numeric|min:0',
        'admin_ratio'     => 'nullable|numeric|min:0',
        'transfer_ratio'  => 'nullable|numeric|min:0',
        'other_ratio'     => 'nullable|numeric|min:0',
        'supply_date'     => 'required|date',
        'statement'       => 'required|string',
        'receipt_number'  => 'required|string|unique:supplies,receipt_number',
        'quantity'        => 'nullable|numeric|min:0',
        'deposit_location'=> 'nullable|string',
        'notes'           => 'nullable|string', 
        'reports'            => 'nullable|array',
        'reports.*.title'    => 'nullable|string',
        'reports.*.due_date' => 'nullable|date',
        'reports.*.type'     => 'nullable',
        'attachments.*'      => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:20480', // حد 20MB للملف
    ]);

    // جلب سعر صرف العملة
    $currency = Currency::findOrFail($request->id_currency);
    $exchange_rate = $currency->exchange_rate ?? 1;

    // --- الحسابات التلقائية ---
    $amount = $request->amount;
    $admin_value    = $amount * (($request->admin_ratio ?? 0) / 100);
    $transfer_value = $amount * (($request->transfer_ratio ?? 0) / 100);
    $other_value    = $amount * (($request->other_ratio ?? 0) / 100);

    // الصافي = الإجمالي - (الإدارة + التحويل + أخرى)
    $net_amount = $amount - ($admin_value + $transfer_value + $other_value);

    $amount_base = $amount * $exchange_rate;
    $net_base    = $net_amount * $exchange_rate;

    // 2. حفظ السند (مع ربطه بالمستخدم الحالي)
    $supply = Supply::create([
        'id_project'       => $request->id_project,
        'id_donor'         => $request->id_donor,
        'id_currency'      => $request->id_currency,
        'id_user'          => auth()->id(), // توثيق مدخل البيانات
        'amount'           => $amount,
        'id_department'  => $request->id_department,
        'quantity'         => $request->quantity,
        'deposit_location' => $request->deposit_location,
        'admin_ratio'      => $request->admin_ratio ?? 0,
        'transfer_ratio'   => $request->transfer_ratio ?? 0,
        'other_ratio'      => $request->other_ratio ?? 0,
        'supply_date'      => $request->supply_date,
        'statement'        => $request->statement,
        'receipt_number'   => $request->receipt_number,
        'id_entity'        => 1, 
        'admin_value'      => $admin_value,
        'transfer_value'   => $transfer_value,
        'other_value'      => $other_value,
        'net_amount'       => $net_amount,
        'exchange_rate'    => $exchange_rate,
        'amount_base_currency'     => $amount_base,
        'net_amount_base_currency' => $net_base,
        'status'           => 'pending',
        'notes'            => $request->notes,
    ]);

    // 3. معالجة وحفظ المرفقات (إثبات التوريد)
    if ($request->hasFile('attachments')) {
    foreach ($request->file('attachments') as $file) {
        // 1. إنشاء اسم فريد للملف
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // 2. تحديد المسار في المجلد العام (public/uploads/attachments)
        $destinationPath = public_path('uploads/attachments');
        
        // 3. نقل الملف فعلياً للمجلد العام
        $file->move($destinationPath, $fileName);
        
        // 4. حفظ المسار الجديد في قاعدة البيانات
        $supply->attachments()->create([
            'file_path' => 'uploads/attachments/' . $fileName, // المسار الذي ستقرأه دالة url()
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
        ]);
    }
}

    // 4. جدولة التقارير المطلوبة للمانح
    if ($request->filled('reports.0.title')) { 
        foreach ($request->reports as $reportData) {
            if (!empty($reportData['title']) && !empty($reportData['due_date'])) {
                DonorReport::create([
                    'id_project'   => $request->id_project,
                    'id_donor'     => $request->id_donor,
                    'id_supply'    => $supply->id_supply,
                    'report_title' => $reportData['title'],
                    'report_type'  => $reportData['type'] ?? 'narrative',
                    'due_date'     => $reportData['due_date'],
                    'status'       => 'pending',
                ]);
            }
        }
    }

    return redirect()->back()->with('success', 'تم تسجيل السند رقم ' . $request->receipt_number . ' وحفظ المرفقات وجدولة التقارير بنجاح');
}
    // عرض التوريدات التي تنتظر الاعتماد
    public function pending()
    {
        $supplies = Supply::with(['project', 'donor', 'currency'])
                    ->where('status', 'pending')
                    ->latest()
                    ->get();
                    
        return view('supplies.pending', compact('supplies'));
    }

    // عملية الاعتماد
    public function approve($id)
    {
        $supply = Supply::findOrFail($id);
        $supply->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'تم اعتماد السند رقم ' . $supply->receipt_number . ' بنجاح.');
    }

    public function rejected()
    {
        $rejectedSupplies = Supply::with(['project', 'donor', 'currency'])
                            ->where('status', 'rejected')
                            ->latest()
                            ->get();
                            
        return view('supplies.rejected', compact('rejectedSupplies'));
    }

    // دالة عرض كشف توريد التبرعات (الواجهة التي صممناها)
public function supplyTable()
{
    // جلب كافة التوريدات مع العلاقات (المشروع، المانح، العملة)
    // لاحظ أننا نستخدم الترتيب التنازلي لرؤية أحدث السندات أولاً
    $supplies = \App\Models\Supply::with(['project', 'donor', 'currency'] )
                ->where('status','approved') 
                ->latest()
                ->get();
    
    // تأكد أن اسم ملف الـ blade مطابق لما أنشأته
    // إذا سميت الملف supply_statement.blade.php سيكون المسار كالتالي:
    return view('reports.supply_statement', compact('supplies'));
}

// دالة حذف السند نهائياً
public function destroy($id)
{
    $supply = Supply::findOrFail($id);
    // حذف التقارير المرتبطة بالسند أولاً إذا وجدت
    \App\Models\DonorReport::where('id_supply', $id)->delete();
    $supply->delete();

    return redirect()->back()->with('success', 'تم حذف السند والتقارير المرتبطة به نهائياً.');
}

// دالة إعادة إرسال الطلب للاعتماد
public function resubmit($id)
{
    $supply = Supply::findOrFail($id);
    $supply->update(['status' => 'pending']);

    return redirect()->route('supplies.pending')->with('success', 'تم إعادة السند رقم ' . $supply->receipt_number . ' إلى قائمة الانتظار.');
}

public function show($id)
{
    // جلب السند مع كل العلاقات المرتبطة
    $supply = Supply::with(['project', 'donor', 'currency', 'attachments', 'reports' => function($query) {
        $query->orderBy('due_date', 'asc');
    }])->findOrFail($id);

    // حساب إجمالي المصروف من هذا السند (سنربطه لاحقاً بجدول Expenses)
    // حالياً سنفترض القيمة صفر حتى نبرمج نظام المصاريف
    $total_spent = 0; 
    $remaining_balance = $supply->net_amount - $total_spent;


    $total_project_spent = DB::table('disbursements')
        ->join('supplies', 'disbursements.id_supply', '=', 'supplies.id_supply')
        ->where('supplies.id_project', $supply->id_project)
        ->sum('disbursements.amount');

        $spent_from_this_supply = DB::table('disbursements')
        ->where('id_supply', $id)
        ->sum('amount');
        
    $remaining_balance = $supply->net_amount - $spent_from_this_supply;

    // 2. جلب كافة عمليات الصرف المرتبطة بهذا السند من جدول Disbursements
    // هذا هو السطر الذي ينقصك لتعريف المتغير
    $disbursements = DB::table('disbursements')
        ->where('id_supply', $id)
        ->orderBy('disbursement_date', 'desc')
        ->get();


    return view('supplies.show', compact('spent_from_this_supply','supply','disbursements','total_project_spent', 'total_spent', 'remaining_balance'));
}

public function reject(Request $request, $id)
{
    // التحقق من وجود سبب الرفض
    $request->validate([
        'rejection_reason' => 'required|string|min:3'
    ]);

    $supply = \App\Models\Supply::findOrFail($id);
    
    $supply->update([
        'status' => 'rejected',
        'rejection_reason' => $request->rejection_reason
    ]);

    return redirect()->route('supplies.pending')->with('error', 'تم رفض السند بنجاح وتوضيح السبب.');
}

// 1. عرض صفحة التعديل (للسندات المرفوضة فقط)
public function edit($id)
{
    $supply = Supply::with(['attachments', 'reports'])->findOrFail($id);
    
    // أمان: منع تعديل السندات المعتمدة نهائياً
    if ($supply->status == 'approved') {
        return redirect()->back()->with('error', 'لا يمكن تعديل سند معتمد نهائياً.');
    }

    $projects = Project::all();
    $donors = Donor::all();
    $currencies = Currency::all();

    return view('supplies.edit', compact('supply', 'projects', 'donors', 'currencies'));
}

// 2. حفظ التعديلات وإعادة السند لحالة "قيد الانتظار"
public function update(Request $request, $id)
{
    $supply = Supply::findOrFail($id);

    // تحديث البيانات الأساسية (مثل كود التخزين الذي استخدمناه في البداية)
    $supply->update([
        'id_project' => $request->id_project,
        'amount'     => $request->amount,
        'statement'  => $request->statement,
        'status'     => 'pending', // إعادة الحالة للانتظار ليراها المدير مجدداً
        'rejection_reason' => null, // مسح سبب الرفض القديم لأننا أصلحنا الخطأ
    ]);

    // هنا يمكنك إضافة كود لرفع مرفقات جديدة إذا رغبت
    
    return redirect()->route('supplies.pending')->with('success', 'تم تعديل السند وإعادة إرساله للاعتماد.');
}




}