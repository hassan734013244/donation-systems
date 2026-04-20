<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
class DepartmentController extends Controller
{
    public function index()
{
    $departments = \App\Models\Department::all();
    return view('departments.index', compact('departments'));
}

public function store(Request $request)
{
    // إضافة شرط unique لجدول departments
    $validated = $request->validate([
        'name_department' => 'required|string|max:255|unique:departments,name_department'
    ], [
        'name_department.unique' => 'عذراً، هذه الإدارة مسجلة مسبقاً لدينا.'
    ]);

    \App\Models\Department::create($validated);
    
    return redirect()->back()->with('success', 'تم إضافة الإدارة بنجاح ✅');
}

public function destroy($id_department)
{
    $department = \App\Models\Department::withCount('users','supplies')->findOrFail($id_department);

    // التصحيح هنا: استخدم السهم -> للوصول للعدد
    if ($department->users_count > 0) {
        return redirect()->back()->with('success', 'لا يمكن حذف هذه الإدارة لوجود موظفين مرتبطين بها!');
    }
    if ($department->supplies_count > 0) {
        return redirect()->back()->with('error', 'لا يمكن حذف الإدارة لوجود (' . $department->supplies_count . ') سندات توريد مسجلة عليها!');
    }

    $department->delete();

    return redirect()->back()->with('success', 'تم حذف الإدارة بنجاح ✅');
}
}
