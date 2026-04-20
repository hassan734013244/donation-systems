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
}