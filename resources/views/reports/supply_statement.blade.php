<x-app-layout>
     <div class="flex justify-between items-center mb-10 no-print" dir="rtl">
               
                <button onclick="window.print()" 
    class="flex items-center bg-emerald-600 text-white px-8 py-3 rounded-xl hover:bg-emerald-700 transition shadow-lg active:scale-95">
    
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z" />
    </svg>

    طباعة الكشف / تصدير PDF
</button>
            </div>
    <div class="py-6 bg-gray-100 min-h-screen no-print-bg">
        <div class="max-w-[98%] mx-auto bg-white p-8 shadow-lg rounded-sm border border-gray-200" id="printableArea">
            
           

            <div class="flex justify-between items-start mb-6 border-b-[3px] border-black pb-6" dir="rtl">
                <div class="text-right flex-1">
                    <h3 class="text-2xl font-black text-gray-900 mb-1">مؤسسة الفتاة التنموية </h3>
                    <p class="text-sm font-bold text-gray-700 uppercase tracking-wide">قسم الشؤون المالية والإدارية</p>
                    <p class="text-[12px] font-medium text-gray-500 mt-2">تاريخ الإصدار: {{ date('Y/m/d') }}</p>
                </div>

                <div class="text-center flex-1 self-center">
                    <div class="relative inline-block">
                        <h1 class="text-2xl font-black border-[3px] border-black px-10 py-3 bg-white shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] relative z-10">
                            كشف توريد تبرعات المشاريع والكفالات المعتمدة
                        </h1>
                    </div>
                </div>

  <div class="flex-1 flex justify-end items-center">
    <div class="w-20 h-20 flex items-center justify-center">
        <img src="{{ asset('images/logo.png') }}" 
             alt="الشعار"
             class="max-h-full max-w-full object-contain"
             style="filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.15));">
    </div>
</div>
            </div>

            <div class="overflow-x-auto" dir="rtl">
                <table class="w-full border-collapse border-[2px] border-black text-[11px] leading-tight">
                    <thead>
                        <tr class="bg-gray-100 text-black font-bold">
                            <th class="border border-black p-2 w-8 text-center">م</th>
                            <th class="border border-black p-2 text-center">التاريخ</th>
                            <th class="border border-black p-2 text-center">المبلغ الإجمالي</th>
                            <th class="border border-black p-2 text-center">اسم المشروع</th>
                            <th class="border border-black p-2 text-center w-10">العدد</th>
                            <th class="border border-black p-2 text-center">فترة التنفيذ</th>
                            <th class="border border-black p-2 text-center">جهة التبرع / الوسيط</th>
                            <th class="border border-black p-2 text-center">جهة التوريد</th>
                            <th class="border border-black p-2 text-center">التحويل</th>
                            <th class="border border-black p-2 text-center">إدارية</th>
                            <th class="border border-black p-2 text-center">أخرى</th>
                            <th class="border border-black p-2 text-center bg-gray-50">صافي المورد</th>
                            <th class="border border-black p-2 text-center">رقم السند</th>
                            <th class="border border-black p-2 text-center w-48">التقارير المطلوبة</th>
                            <th class="border border-black p-2 text-center">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900 font-medium">
                        @foreach($supplies as $index => $supply)
                        <tr class="border-b border-black hover:bg-gray-50 transition-colors">
                            <td class="border border-black p-1.5 text-center font-bold">{{ $index + 1 }}</td>
                            <td class="border border-black p-1.5 text-center whitespace-nowrap">{{ $supply->supply_date }}</td>
                            <td class="border border-black p-1.5 text-center font-black whitespace-nowrap">
                                {{ number_format($supply->amount, 2) }} 
                                <span class="text-[9px] text-gray-600">{{ $supply->currency->symbol ?? '' }}</span>
                            </td>
                            <td class="border border-black p-1.5 pr-2 font-bold">{{ $supply->project->project_name ?? '---' }}</td>
                            <td class="border border-black p-1.5 text-center">{{ $supply->quantity ?? '-' }}</td>
                            
                            <td class="border border-black p-1 text-center text-[10px] leading-[1]">
                                @if(isset($supply->project->start_date))
                                    {{ $supply->project->start_date }} <br> <span class="font-bold">إلى</span> <br> {{ $supply->project->end_date }}
                                @else
                                    -
                                @endif
                            </td>

                            <td class="border border-black p-1.5 pr-2">{{ $supply->donor->donor_name ?? '---' }}</td>
                            <td class="border border-black p-1.5 text-center font-bold text-indigo-800">{{ $supply->deposit_location ?? '---' }}</td>
                            
                            <td class="border border-black p-1.5 text-center text-red-600">{{ $supply->transfer_ratio ?? 0 }}%</td>
                            <td class="border border-black p-1.5 text-center text-red-600">{{ $supply->admin_ratio ?? 0 }}%</td>
                            <td class="border border-black p-1.5 text-center text-red-600">{{ $supply->other_ratio ?? 0 }}%</td>
                            
                            <td class="border border-black p-1.5 text-center font-black bg-gray-100 text-[11px] whitespace-nowrap">
                                {{ number_format($supply->net_amount, 2) }}
                                <span class="text-[9px] text-emerald-700">{{ $supply->currency->symbol ?? '' }}</span>
                            </td>
                            
                            <td class="border border-black p-1.5 text-center font-mono font-black text-gray-700">{{ $supply->receipt_number }}</td>
                            
                            <td class="border border-black p-1.5 text-[10px] leading-tight pr-1">
@forelse($supply->reports as $report)
    <div>• {{ $report->report_title }}</div>
@empty
    <div class="text-gray-400">لا يوجد تقارير مرتبطة بهذا السند</div>
@endforelse
                                <!--{{ $supply->notes }} -->
                            </td>

                            <td class="border border-black p-1.5 text-[9px] pr-1 leading-tight">{{ Str::limit($supply->statement, 80) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-200 font-black text-black border-[2px] border-black">
    <tr class="h-12">
        <td colspan="2" class="border border-black p-2 text-center text-[11px] leading-tight bg-gray-300">
            الإجمالي بالعملة الأساسية <br>
            <span class="text-[9px] font-medium text-gray-600">(مقابل سعر الصرف المعتمد)</span>
        </td>
        
        <td class="border border-black p-2 text-center text-[12px] bg-yellow-50">
            {{ number_format($supplies->sum('amount_base_currency'), 2) }}
            <span class="text-[9px] block text-gray-500">عملة الأساس</span>
        </td>
        
        <td colspan="8" class="border border-black p-2 bg-gray-50"></td>
        
        <td class="border border-black p-2 text-center text-[12px] bg-emerald-100 text-emerald-900">
            {{ number_format($supplies->sum('net_amount_base_currency'), 2) }}
            <span class="text-[9px] block text-emerald-600 italic">الصافي الفعلي</span>
        </td>
        
        <td colspan="3" class="border border-black p-2 bg-gray-50"></td>
    </tr>
</tfoot>
                </table>
            </div>

            <div class="mt-16 hidden print:grid grid-cols-4 gap-4 text-center font-black text-sm" dir="rtl">
                <div class="border-t border-black pt-2">إعداد المحاسب</div>
                <div class="border-t border-black pt-2">المدير المالي</div>
                <div class="border-t border-black pt-2">المراجعة الداخلية</div>
                <div class="border-t border-black pt-2">يعتمد / المدير العام</div>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-100 text-center text-[10px] text-gray-400 no-print">
                نظام إدارة التبرعات - تم التطوير بواسطة المهندس :حسن الأهدل &copy; 2026
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; margin: 0; padding: 0; }
            .py-6 { padding: 0 !important; }
            .shadow-lg { box-shadow: none !important; }
            .max-w-\[98\%\] { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
            .border-gray-200 { border: none !important; }
            
            table { 
                width: 100% !important; 
                table-layout: auto !important; 
                font-size: 10px !important; 
                border: 2px solid black !important;
            }
            th, td { border: 1px solid black !important; padding: 4px !important; }
            
            @page { 
                size: landscape; 
                margin: 0.8cm; 
            }
        }

       
    #printableArea {
        position: relative;
    }
    #printableArea::after {
        content: "مؤسسة الفتاة التنموية ";
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 80px;
        color: rgba(0, 0, 0, 0.03); /* لون شفاف جداً */
        font-weight: bold;
        z-index: 0;
        pointer-events: none;
        white-space: nowrap;
    }

    </style>
</x-app-layout>