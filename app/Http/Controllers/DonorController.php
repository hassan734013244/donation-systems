<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::latest('id_donor')->get();
        return view('donors.index', compact('donors'));
    }

public function store(Request $request)
{
    // دمج جميع الشروط في مصفوفة واحدة لضمان حفظ كل البيانات في $validated
    $validated = $request->validate([
        'donor_name' => 'required|string|max:255|unique:donors,donor_name',
        'donor_type' => 'required|in:individual,organization',
    ], [
        // رسائل الخطأ المخصصة
        'donor_name.unique' => 'هذا المتبرع مضاف مسبقاً.',
        'donor_name.required' => 'اسم المتبرع مطلوب.',
        'donor_type.required' => 'يرجى تحديد نوع المتبرع.',
    ]);

    // الآن $validated تحتوي على الاسم والنوع معاً
    Donor::create($validated);

    return redirect()->back()->with('success', 'تم إضافة المتبرع بنجاح');
}

public function destroy($id)
{
    // 1. جلب بيانات المتبرع أو إظهار 404 إذا لم يكن موجوداً
    $donor = Donor::where('id_donor', $id)->firstOrFail();

    // 2. التحقق مما إذا كان للمتبرع أي توريدات مرتبطة به
    // نفترض أن اسم العلاقة في موديل Donor هو supplies
    if ($donor->supplies()->exists()) {
        return redirect()->back()->with('error', 'لا يمكن حذف هذا المتبرع لوجود توريدات مالية مرتبطة به في النظام.');
    }

    // 3. إذا لم توجد توريدات، يتم الحذف بأمان
    $donor->delete();

    return redirect()->back()->with('success', 'تم حذف المتبرع بنجاح.');
}
}