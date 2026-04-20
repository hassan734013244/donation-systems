<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. بناء الاستعلام الأساسي مع الربط
       $query = DB::table('supplies')
        ->join('projects', 'supplies.id_project', '=', 'projects.id_project')
        ->join('currencies', 'supplies.id_currency', '=', 'currencies.id_currency')
        ->leftJoin('donors', 'supplies.id_donor', '=', 'donors.id_donor')
        ->leftJoin('departments', 'supplies.id_department', '=', 'departments.id_department')
        ->select(
            'supplies.*', 
            'projects.project_name', 
            'currencies.symbol as currency_symbol',
            'departments.name_department',
            'donors.donor_name as donor_full_name'
        );

        // 2. تطبيق الفلاتر (إذا وجدت)
        if ($request->filled('project_id')) {
            $query->where('supplies.id_project', $request->project_id);
        }

        if ($request->filled('search')) {
            $query->where('supplies.receipt_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('supplies.supply_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('supplies.supply_date', '<=', $request->to_date);
        }

        // 3. جلب البيانات مع الترقيم (20 سجل لكل صفحة)
        $supplies = $query->orderBy('supplies.supply_date', 'desc')->paginate(20);
        
        // 4. جلب المشاريع لقائمة الفلتر
        $projects = DB::table('projects')->get();

        return view('reports.all_supplies', compact('supplies', 'projects'));
    }
}