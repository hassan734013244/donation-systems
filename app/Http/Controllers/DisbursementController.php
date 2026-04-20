<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisbursementController extends Controller
{
    public function index()
    {
        $disbursements = DB::table('disbursements')
            ->join('supplies', 'disbursements.id_supply', '=', 'supplies.id_supply')
            ->select('disbursements.*', 'supplies.receipt_number')
            ->latest()
            ->paginate(10);

        return view('disbursements.index', compact('disbursements'));
    }

    public function create()
    {
       // جلب السندات مع أسماء المشاريع المرتبطة بها
    $supplies = DB::table('supplies')
        ->join('projects', 'supplies.id_project', '=', 'projects.id_project')
        ->select('supplies.*', 'projects.project_name')
        ->get();

    return view('disbursements.create', compact('supplies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_supply' => 'required|exists:supplies,id_supply',
            'amount' => 'required|numeric|min:0.01',
            'beneficiary_name' => 'required|string|max:255',
            'statement'         => 'required|string', // حفظ البيان هنا
            
        ]);

        // التصحيح هنا: البحث بـ id_supply وليس id
        $supply = DB::table('supplies')->where('id_supply', $request->id_supply)->first();
        
        $totalSpent = DB::table('disbursements')
                        ->where('id_supply', $request->id_supply)
                        ->sum('amount');

        $remainingBalance = $supply->net_amount - $totalSpent;

        if ($request->amount > $remainingBalance) {
            return back()->withInput()->withErrors([
                'amount' => "عفواً! المبلغ المطلوب أكبر من الرصيد المتبقي ($remainingBalance ريال)."
            ]);
        }

        DB::table('disbursements')->insert([
            'id_supply' => $request->id_supply,
            'amount' => $request->amount,
            'beneficiary_name'  => $request->beneficiary_name,
            'statement'         => $request->statement, // حفظ البيان هنا
            'disbursement_date' => now(), 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('disbursements.index')
            ->with('success', 'تم تسجيل سند الصرف بنجاح للمستفيد: ' . $request->beneficiary_name);
    }

   public function getRemainingBalance($id)
{
    try {
        // 1. جلب بيانات التوريد
        $supply = DB::table('supplies')->where('id_supply', $id)->first();
        
        if (!$supply) {
            return response()->json(['error' => 'سند التوريد غير موجود'], 404);
        }

        // 2. حساب إجمالي الصرفيات السابقة
        $totalDisbursed = DB::table('disbursements')
                            ->where('id_supply', $id)
                            ->sum('amount');
        
        // 3. الرصيد المتاح حالياً
        $remaining = $supply->net_amount - $totalDisbursed;

        // 4. جلب اسم المشروع
        $projectName = DB::table('projects')
                         ->where('id_project', $supply->id_project)
                         ->value('project_name');

        return response()->json([
            'remaining' => $remaining,
            'project_name' => $projectName ?? 'مشروع غير محدد'
        ]);

    } catch (\Exception $e) {
        // في حال حدوث خطأ برمجي، سيظهر لك السبب في الـ Network
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function show($id)
{
    // 1. جلب بيانات السند الحالي (مع التأكد من وجود id_supply)
    $disbursement = DB::table('disbursements')->where('id_disbursement', $id)->first();

    if (!$disbursement) {
        abort(404);
    }

    // 2. جلب رقم المشروع المرتبط بهذا السند من جدول التوريدات
    $supply = DB::table('supplies')->where('id_supply', $disbursement->id_supply)->first();

    // 3. حساب إجمالي مصروفات هذا المشروع (كل الصرفيات المرتبطة بكل توريدات المشروع)
    $total_spent = DB::table('disbursements')
        ->join('supplies', 'disbursements.id_supply', '=', 'supplies.id_supply')
        ->where('supplies.id_project', $supply->id_project)
        ->sum('disbursements.amount');

    // 4. الربط الحاسم: إرسال المتغير للـ Blade
    return view('disbursements.show', compact('disbursement', 'total_spent', 'supply'));
}


public function destroy($id)
{
    // حذف العملية بناءً على المعرف
    DB::table('disbursements')->where('id_disbursement', $id)->delete();

    // العودة مع رسالة نجاح
    return redirect()->back()->with('success', 'تم حذف عملية الصرف بنجاح وتحديث الرصيد.');
}
}