<?php

namespace App\Http\Controllers;

use App\Models\DonorReport;
use App\Models\Project;
use App\Models\Donor;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        // يعتبر مديراً إذا كان دوره 1 أو إذا كان حقل الإدارة فارغاً
        $isAdmin = ($user->id_role == 1 || is_null($user->id_department));

        // جلب المشاريع والمانحين لعمل الفلاتر
        $projects = Project::all();
        $donors = Donor::all();

        // 1. بناء الاستعلام الأساسي مع العلاقات
        $query = DonorReport::with(['project', 'supply.donor', 'supply.department']);

        // --- تطبيق فلترة الإدارة للموظفين فقط ---
        if (!$isAdmin) {
            $query->whereHas('supply', function ($q) use ($user) {
                $q->where('id_department', $user->id_department);
            });
        }

        // 2. تطبيق فلاتر المستخدم (المشروع والحالة)
        if ($request->filled('project_id')) {
            $query->where('id_project', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. جلب النتائج مع الترتيب والترقيم
        $reports = $query->orderBy('due_date', 'asc')->paginate(15);

        // 4. إحصائيات مفلترة (لتعبر عن محتوى الجدول المعروض)
        // نستخدم استنساخ للاستعلام لكي لا تتأثر الفلاتر ببعضها
        $stats = [
            'total'     => (clone $query)->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'overdue'   => (clone $query)->where('status', 'overdue')->count(),
            'pending'   => (clone $query)->where('status', 'pending')->count(),
        ];

        // حساب نسبة الإنجاز بناءً على الإحصائيات المفلترة
        $completionRate = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0;

        return view('reports.index', compact('reports', 'projects', 'donors', 'stats', 'completionRate'));
    }

    public function complete(Request $request, $id)
    {
        $request->validate([
            'report_file' => 'required|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $report = DonorReport::findOrFail($id);

        if ($request->hasFile('report_file')) {
            $file = $request->file('report_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // حفظ الملف في: public/uploads/reports
            $file->move(public_path('uploads/reports'), $fileName);
            
            $pathForDb = 'uploads/reports/' . $fileName;

            $report->update([
                'report_file' => $pathForDb,
                'status' => 'completed',
            ]);
        }

        return back()->with('success', 'تم رفع التقرير بنجاح!');
    }
}