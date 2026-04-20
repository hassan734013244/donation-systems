<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use App\Models\Supply;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    // أضف هذه الدالة بدقة داخل الكلاس
public function store(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'notes'  => 'nullable|string',
    ]);

    // تأكد أن id_supply هو اسم المفتاح الأساسي في جدولك
    $supply = Supply::findOrFail($id);

    // 1. تسجيل القرار في جدول الـ Approvals
    Approval::create([
        'id_supply'     => $supply->id_supply,
        'user_id'       => Auth::id(),
        'role_name'     => Auth::user()->roles->first()->role_name ?? 'مدير',
        'status'        => $request->status, 
        'approval_date' => now(),
        'notes'         => $request->notes,
    ]);

    // 2. تحديث حالة السند مباشرة (لضمان التغيير فوراً)
    $supply->update([
        'status' => $request->status
    ]);

    $message = $request->status == 'approved' ? 'تم الاعتماد بنجاح' : 'تم الرفض بنجاح';
    
    return redirect()->back()->with('success', $message);
}
}