<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // جلب المستخدمين مع إداراتهم وأدوارهم لتقليل ضغط الاستعلامات
        $users = User::with(['department', 'roles'])->get();
        $departments = Department::all();
        $roles = Role::all(); // افترضنا وجود موديل Role
        
       $stats = [
        'total_users' => User::count(),
        'total_depts' => Department::count(),
        'admins_count' => \DB::table('role_user')
                            ->join('roles', 'role_user.id_role', '=', 'roles.id_role')
                            ->where('roles.role_name', 'مدير النظام')
                            ->count(),
    ];
    
    return view('users.index', compact('users', 'departments', 'roles', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'id_department' => 'required|exists:departments,id_department',
            'id_role' => 'required|exists:roles,id_role', 
        ]);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'id_department' => $validated['id_department'],
            'id_role' => $validated['id_role'],
        ]);

        // ربط الدور في الجدول الوسيط role_user
        $user->roles()->attach($validated['id_role']);

        return redirect()->back()->with('success', 'تم إضافة المستخدم ومنحه الصلاحيات بنجاح ✅');
    }
}