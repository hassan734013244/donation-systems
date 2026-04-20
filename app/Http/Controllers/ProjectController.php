<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    // عرض قائمة المشاريع
    public function index()
    {
        $projects = Project::latest('id_project')->get();
        return view('projects.index', compact('projects'));
    }

    // حفظ مشروع جديد
public function store(Request $request)
{
    // 1. التحقق من بيانات المشروع والتقارير
    $validated = $request->validate([
        'project_name' => 'required|string|max:255|unique:projects,project_name',
        'status'       => 'required',
        'start_date'   => 'required|date',
        'end_date'     => 'required|date',
        // التحقق من التقارير إذا تم إدخالها
        'reports.*.title'    => 'nullable|string|max:255',
        'reports.*.due_date' => 'nullable|date',
    ]);

    // 2. حفظ المشروع
    $project = Project::create([
        'project_name' => $request->project_name,
        'status'       => $request->status,
        'start_date'   => $request->start_date,
        'end_date'     => $request->end_date,
    ]);

    // 3. حفظ التقارير المرتبطة (فقط إذا كانت البيانات غير فارغة)
    if ($request->has('reports')) {
        foreach ($request->reports as $reportData) {
            if (!empty($reportData['title']) && !empty($reportData['due_date'])) {
                \App\Models\DonorReport::create([
                    'id_project'   => $project->id_project, // الربط مع المشروع المنشأ حديثاً
                    'id_donor'     => $request->id_donor ?? 1, // تأكد من وجود id_donor في الفورم
                    'report_title' => $reportData['title'],
                    'report_type'  => $reportData['type'] ?? 'narrative',
                    'due_date'     => $reportData['due_date'],
                    'status'       => 'pending',
                ]);
            }
        }
    }

    return redirect()->back()->with('success', 'تم حفظ المشروع  بنجاح');
}
    // تحديث حالة المشروع
    public function update_status(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->only('status'));

        

        return redirect()->back()->with('success', 'تم تحديث الحالة بنجاح');
    }

    // دالة عرض صفحة التعديل
public function edit($id)
{
    // جلب بيانات المشروع باستخدام المعرف
    $project = DB::table('projects')->where('id_project', $id)->first();

    // التأكد من وجود المشروع
    if (!$project) {
        return redirect()->route('projects.index')->with('error', 'المشروع غير موجود.');
    }

    return view('projects.edit', compact('project'));
}

// دالة تنفيذ التحديث (تُستخدم عند إرسال الفورم من صفحة التعديل)
public function update(Request $request, $id)
{
    $request->validate([
        'project_name' => 'required',
        'status' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    ]);

    DB::table('projects')->where('id_project', $id)->update([
        'project_name' => $request->project_name,
        'status' => $request->status,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'updated_at' => now(),
    ]);

    return redirect()->route('projects.index')->with('success', 'تم تحديث المشروع بنجاح');
}
}