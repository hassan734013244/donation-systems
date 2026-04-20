<?php
use App\Models\Supply;
use App\Models\Project;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\MediaController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController; 


use App\Http\Controllers\DisbursementController;

use App\Http\Controllers\SupplyReportController;

use Illuminate\Support\Facades\Route;









Route::get('/', function () {
    return view('/auth.login');
});


// مسار عرض صفحة التعديل
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');

// مسار عرض صفحة التعديل للصفحة الإدارات
Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');


// مسار تنفيذ عملية التحديث في قاعدة البيانات
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');

// مسار الحذف (إذا لم يكن موجوداً)
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

Route::get('/all-supplies-report', [SupplyReportController::class, 'index'])->name('reports.supplies');
Route::middleware(['auth'])->group(function () {
    // مسارات الإدارات
    Route::resource('departments', DepartmentController::class);
    Route::get('/media-reports', [MediaController::class, 'index'])->name('media.index');
    // مسار المستخدمين (مبدئياً)
   Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});


Route::get('/get-balance/{id}', [DisbursementController::class, 'getRemainingBalance']);

Route::resource('disbursements', DisbursementController::class);

Route::delete('/disbursements/{id}', [App\Http\Controllers\DisbursementController::class, 'destroy'])
    ->name('disbursements.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');

Route::get('/supply-statement', [SupplyController::class, 'supplyTable'])->name('reports.supplyTable');

    Route::post('/approvals/{id}', [ApprovalController::class, 'store'])->name('approvals.store');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::patch('/projects/{id}', [ProjectController::class, 'update_status'])->name('projects.update_status');
    Route::get('/donors', [DonorController::class, 'index'])->name('donors.index');
    Route::post('/donors', [DonorController::class, 'store'])->name('donors.store');
    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
    Route::patch('/currencies/{id}', [CurrencyController::class, 'update'])->name('currencies.update');


    
    Route::get('/supplies/pending', [SupplyController::class, 'pending'])->name('supplies.pending');
Route::patch('/supplies/{id}/approve', [SupplyController::class, 'approve'])->name('supplies.approve');
// مسار عرض السندات المرفوضة
Route::get('/supplies/rejected', [App\Http\Controllers\SupplyController::class, 'rejected'])->name('supplies.rejected');

// مسار معالجة عملية الرفض
Route::post('/supplies/{id}/reject', [App\Http\Controllers\SupplyController::class, 'reject'])->name('supplies.reject');

// وإذا لم تكن قد أضفت مسار الاعتماد أيضاً، أضفه الآن:
Route::post('/supplies/{id}/approve', [App\Http\Controllers\SupplyController::class, 'approve'])->name('supplies.approve');

Route::patch('/reports/{id}/complete', function ($id) {
    $report = \App\Models\DonorReport::findOrFail($id);
    $report->update([
        'status' => 'submitted', // تغيير الحالة إلى تم التسليم
        'notes' => ($report->notes . "\n تم التأكيد في: " . now()->toDateTimeString())
    ]);

    return redirect()->back()->with('success', 'تم تحديث حالة التقرير إلى "تم التسليم" بنجاح ✅');
})->name('reports.complete');

Route::get('/reports-log', [ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/supplies/create', [SupplyController::class, 'create'])->name('supplies.create');
    Route::post('/supplies/store', [SupplyController::class, 'store'])->name('supplies.store');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $isAdmin = ($user->id_role == 1 || is_null($user->id_department));

    // 1. تحديث تلقائي للحالة
    \App\Models\DonorReport::where('status', 'pending')
        ->where('due_date', '<', now()->toDateString())
        ->update(['status' => 'overdue']);

    // 2. الإحصائيات (فلترة التوريدات بحسب إدارة الموظف)
    $statsQuery = \App\Models\Supply::where('status', 'approved');
    if (!$isAdmin) {
        $statsQuery->where('id_department', $user->id_department);
    }

    $stats = [
        'total_donations' => $statsQuery->sum('amount'),
        'pending_supplies' => \App\Models\Supply::where('status', 'pending')
                                ->when(!$isAdmin, function($q) use ($user) {
                                    return $q->where('id_department', $user->id_department);
                                })->count(),
        'active_projects' => \App\Models\Project::where('status', 'active')->count(),
    ];

    // 3. بناء استعلام التقارير المتأخرة مع الفلترة عبر جدول التوريدات
    $overdueQuery = \App\Models\DonorReport::with(['project', 'supply'])
        ->where('status', 'overdue')
        ->orderBy('due_date', 'asc');

    // 4. بناء استعلام التقارير القادمة مع الفلترة عبر جدول التوريدات
    $upcomingQuery = \App\Models\DonorReport::with(['project', 'donor', 'supply'])
        ->where('status', 'pending')
        ->whereBetween('due_date', [now()->toDateString(), now()->addDays(7)->toDateString()])
        ->orderBy('due_date', 'asc');

    // --- هنا السحر: الفلترة بناءً على علاقة التقرير بالتوريد المرتبط بإدارة المستخدم ---
    if (!$isAdmin) {
        $overdueQuery->whereHas('supply', function ($query) use ($user) {
            $query->where('id_department', $user->id_department);
        });

        $upcomingQuery->whereHas('supply', function ($query) use ($user) {
            $query->where('id_department', $user->id_department);
        });
    }

    $overdueReports = $overdueQuery->get();
    $upcomingReports = $upcomingQuery->get();

    return view('dashboard', compact('stats', 'overdueReports', 'upcomingReports'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// مسار الحذف
Route::delete('/supplies/{id}', [SupplyController::class, 'destroy'])->name('supplies.destroy');

// مسار إعادة الإرسال (نستخدم PUT لأننا نعدل حالة موجودة)
Route::put('/supplies/{id}/resubmit', [SupplyController::class, 'resubmit'])->name('supplies.resubmit');
require __DIR__.'/auth.php';

// مسار عرض تفاصيل السند
Route::get('/supplies/{id}/details', [SupplyController::class, 'show'])->name('supplies.show');

// مسار عرض صفحة التعديل
Route::get('/supplies/{id}/edit', [App\Http\Controllers\SupplyController::class, 'edit'])->name('supplies.edit');

// مسار تحديث البيانات في قاعدة البيانات
Route::put('/supplies/{id}/update', [App\Http\Controllers\SupplyController::class, 'update'])->name('supplies.update');

// هذا الرابط خاص للمتبرعين - يفتح بدون تسجيل دخول
Route::get('/share/details/{id}', [App\Http\Controllers\MediaController::class, 'publicShow'])
    ->name('supplies.public_show')
    ->middleware('signed'); // هذه "القفلة" تضمن أن الرابط لا يمكن تزويره

Route::post('/reports/complete/{id}', [App\Http\Controllers\ReportController::class, 'complete'])
    ->name('reports.complete');
