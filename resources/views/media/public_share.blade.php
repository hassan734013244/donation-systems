<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير مشروع - مؤسسة الفتاة اليمنية التنموية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Tajawal', sans-serif; } 
        /* تنسيق خاص للطباعة للحفاظ على الألوان والمظهر */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; p: 0; }
            .max-w-5xl { max-width: 100% !important; width: 100% !important; }
            .bg-blue-600 { background-color: #2563eb !important; -webkit-print-color-adjust: exact; color: white !important; }
            .bg-white { box-shadow: none !important; border: none !important; }
        }
    </style>
</head>
<body class="bg-gray-50 p-4 md:p-8">
    <div class="max-w-5xl mx-auto">
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6 flex justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-20 h-20 flex items-center justify-center rounded-xl bg-gray-50 border border-gray-100 p-2">
                    @if(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="شعار مؤسسة الفتاة اليمنية للتنمية" class="max-h-full max-w-full">
                    @else
                        <span class="text-4xl">🌱</span>
                    @endif
                </div>

                <div>
                    <h1 class="text-xl font-black text-gray-900">مؤسسة الفتاة اليمنية التنموية  </h1>
                    <p class="text-gray-500 text-sm">نظام الشفافية وتقارير المتبرعين (المتبرع الكريم : {{ $supply->donor->donor_name ?? 'فاعل خير' }})</p>
                
                </div>
            </div>
            
            <div class="text-left flex flex-col items-end gap-2">
                <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 px-4 py-1 rounded-full text-xs font-bold">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    سند معتمد ✓
                </span>
                <span class="text-xs text-gray-400">تاريخ التقرير: {{ date('Y-m-d') }}</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-600 p-6 rounded-2xl text-white shadow-xl shadow-blue-100 border border-blue-700">
                <p class="text-blue-100 text-xs font-bold mb-1">المبلغ المورد للمشروع</p>
                <h4 class="text-4xl font-black">{{ number_format($supply->net_amount, 2) }} <span class="text-sm font-normal">{{ $supply->currency->symbol }}</span></h4>
                <p class="text-[10px] text-blue-200 mt-1 italic">سند رقم: #{{ $supply->receipt_number }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold mb-1">إجمالي ما تم صرفه</p>
                    <h4 class="text-3xl font-black text-rose-rose">{{ number_format($total_project_spent, 2) }} <span class="text-xs text-gray-400">{{ $supply->currency->symbol }}</span></h4>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $supply->net_amount > 0 ? ($total_project_spent / $supply->net_amount) * 100 : 0 }}%"></div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-gray-400 text-xs font-bold mb-1">الرصيد المتبقي (المتاح)</p>
                    <h4 class="text-3xl font-black text-emerald-600">{{ number_format($remaining_balance, 2) }} <span class="text-xs text-gray-400">{{ $supply->currency->symbol }}</span></h4>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $supply->net_amount > 0 ? ($remaining_balance / $supply->net_amount) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white shadow-sm rounded-2xl overflow-hidden border">
                    <div class="bg-gray-50 px-6 py-4 border-b font-bold text-gray-700 flex justify-between items-center">
                        <span>💸 تفاصيل التنفيذ الميداني والصرف</span>
                        <span class="text-xs text-gray-400 italic">عدد العمليات: {{ $disbursements->count() }}</span>
                    </div>
                    <table class="w-full text-right text-sm">
                        <thead>
                            <tr class="text-gray-400 border-b">
                                <th class="px-6 py-3 font-bold text-xs uppercase">المستفيد/البيان</th>
                                <th class="px-6 py-3 font-bold text-xs uppercase text-center">المبلغ</th>
                                <th class="px-6 py-3 font-bold text-xs uppercase text-center">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($disbursements as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 italic font-medium text-gray-700">{{ $item->beneficiary_name }} <br> <span class="text-[10px] text-gray-400 leading-relaxed max-w-xs">{{ $item->statement }}</span></td>
                                <td class="px-6 py-4 text-center font-bold text-rose-500">{{ number_format($item->amount, 2) }}</td>
                                <td class="px-6 py-4 text-center text-gray-400 text-xs">{{ $item->disbursement_date }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">لا توجد عمليات صرف مسجلة لهذا السند حتى الآن.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white shadow-sm rounded-2xl p-6 border">
                    <h4 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                        🖼️ صور وفيديوهات التوثيق الميداني
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @forelse($supply->attachments as $file)
                            <div class="relative group border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                               @if(in_array(strtolower($file->file_type), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <img src="{{ asset($file->file_path) }}" class="h-32 w-full object-cover">
                                @elseif($file->file_type == 'mp4')
                                    <video class="h-32 w-full object-cover" controls><source src="{{ asset('storage/' . $file->file_path) }}" type="video/mp4"></video>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm col-span-3 text-center py-10 italic">لا توجد مرفقات توثيقية لهذا السند</p>
                        @endforelse
                    </div>
                </div>
    
            </div>

            <div class="space-y-6">
                <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100 shadow-sm shadow-indigo-50">
                    <h4 class="font-bold text-indigo-900 mb-2 underline flex items-center gap-2">
                        <span>💡</span> معلومات المشروع المستفيد
                    </h4>
                    <p class="text-sm text-indigo-800 leading-relaxed font-bold">{{ $supply->project->project_name }}</p>
                    <hr class="my-4 border-indigo-200">
                    <p class="text-xs text-indigo-600 italic leading-relaxed">{{ $supply->statement }}</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <p class="text-gray-400 text-xs mb-2">تاريخ انتهاء المشروع</p>
                    <p class="font-black text-gray-700 text-lg italic bg-gray-50 px-3 py-1 rounded-lg">
                        {{ $supply->project->is_continuous ? 'مستمر طوال العام' : $supply->project->end_date }}
                    </p>
                </div>
            </div>
        </div>
                    
<div class="bg-white shadow-sm rounded-2xl p-6 border mt-6">
    <h4 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
        <span class="ml-2">📄</span> التقارير الإنجازية المعتمدة
    </h4>
    @if($supply->reports->where('status', 'completed')->count() > 0)
    <div class="grid grid-cols-1 gap-4">
        @foreach($supply->reports->where('status', 'completed') as $report)
            <div class="flex items-center justify-between p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-600 text-white p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-emerald-900">{{ $report->report_title }}</p>
                        <p class="text-[10px] text-emerald-600 italic">تم الإنجاز في: {{ $report->updated_at->format('Y-m-d') }}</p>
                    </div>
                </div>
                @if($report->report_file)
                 <a href="{{asset($report->report_file)}}" target="_blank" class="...">
                <span>تحميل التقرير</span>
                   </a>
                  @endif

                  @if($report->status == 'completed')
    <a href="{{asset($report->report_file)}}" target="_blank" class="...">
        👁️ معاينة التقرير
    </a>
@endif
            </div>
        @endforeach
    </div>
</div>
@endif
</div>

        <div class="mt-12 text-center pb-10 border-t border-gray-100 pt-6 no-print">
            <p class="text-gray-400 text-xs italic">نشكركم على دعمكم ومساهمتكم الكريمة في نماء المجتمع - مؤسسة الفتاة اليمنية التنموية</p>
            <button onclick="window.print()" class="mt-4 text-xs text-indigo-600 hover:underline">🖨️ طباعة التقرير / حفظ PDF</button>
        </div>
    </div>
</body>
</html>