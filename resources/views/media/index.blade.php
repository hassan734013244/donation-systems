<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen" dir="rtl">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-8" dir="rtl">
    <form action="{{ route('media.index') }}" method="GET" 
          class="flex flex-wrap md:flex-nowrap items-end gap-4">

        <!-- البحث عن مشروع -->
        <div class="flex-1 min-w-[220px] space-y-2">
            <label class="block text-xs font-black text-slate-500 mr-2">ابحث عن مشروع</label>
            <div class="relative">
                <input type="text" name="project_search" value="{{ request('project_search') }}" 
                       class="w-full bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 py-3 pr-10 text-sm font-bold text-slate-700" 
                       placeholder="مثال: مشروع مياه...">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400">🔍</span>
            </div>
        </div>

        <!-- رقم السند -->
        <div class="w-40 space-y-2">
            <label class="block text-xs font-black text-slate-500 mr-2">رقم السند</label>
            <input type="text" name="receipt_number" value="{{ request('receipt_number') }}" 
                   class="w-full bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 py-3 text-sm font-bold text-slate-700" 
                   placeholder="0000">
        </div>

        <!-- من تاريخ -->
        <div class="w-40 space-y-2">
            <label class="block text-xs font-black text-slate-500 mr-2">من تاريخ</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" 
                   class="w-full bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 py-3 text-sm font-bold text-slate-700">
        </div>

        <!-- الأزرار -->
        <div class="flex items-center gap-2">
            <button type="submit" 
    class="bg-indigo-600 hover:!bg-indigo-700 !text-white font-bold px-6 py-3 rounded-2xl shadow-md transition whitespace-nowrap">
    تطبيق
</button>

            <a href="{{ route('media.index') }}" 
               class="p-3 bg-slate-100 text-slate-500 rounded-2xl hover:bg-slate-200 transition"
               title="إعادة ضبط">
                🔄
            </a>
        </div>

    </form>
</div>
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <div>
                    <h1 class="text-3xl font-black text-indigo-900 border-r-8 border-indigo-600 pr-4">
                        سجل التوريدات الإعلامي
                    </h1>
                    <p class="text-gray-500 mt-2 mr-6 text-sm">متابعة المشاريع، القيم الصافية، وفترات التنفيذ</p>
                </div>
                
                <div class="flex gap-3">
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl shadow-xl shadow-emerald-100 transition-all font-bold flex items-center gap-2">
                        <span>📥</span> تصدير Excel
                    </button>
                    <button onclick="window.print()" class="bg-white text-gray-700 border border-gray-200 px-6 py-3 rounded-2xl shadow-sm hover:bg-gray-50 transition-all font-bold flex items-center gap-2">
                        <span>🖨️</span> طباعة PDF
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-right border-collapse">
                    <thead>
    <tr class="bg-slate-800 "> 
        <th class="px-8 py-6 font-black text-sm uppercase tracking-wider text-right border-b border-slate-700">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                تفاصيل المشروع
            </span>
        </th>
        <th class="px-8 py-6 font-black text-sm uppercase tracking-wider text-center border-b border-slate-700"> الإدارة</th>
        <th class="px-8 py-6 font-black text-sm uppercase tracking-wider text-center border-b border-slate-700">العدد</th>
        <th class="px-8 py-6 font-black text-sm uppercase tracking-wider text-center border-b border-slate-700">فترة التنفيذ</th>
        <th class="px-8 py-6 font-black text-sm uppercase tracking-wider text-left border-b border-slate-700">المبلغ الصافي</th>
    </tr>
</thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($reports as $report)
                        <tr class="hover:bg-indigo-50/40 transition-all duration-300">
                            <td class="px-8 py-5">
                                <div class="font-bold text-gray-900 text-lg">{{ $report->project_name }} / المتبرع ({{ $report->donor_name }})</div>
                                <div class="text-xs text-gray-400 mt-1">تاريخ العملية: {{ $report->supply_date }}</div>
                            </td>
                            <td class="px-8 py-5">
                            <div class="font-bold text-gray-900 text-lg"> {{ $report->name_department }}</div>
                            </td>
                            
                            <td class="px-8 py-5 text-center">
                                <div class="font-black text-gray-700">{{ $report->quantity ?? 1 }}</div>
                                
                            </td>
                            <td class="px-8 py-5 text-center">
    <div class="inline-flex flex-col items-center gap-1 px-4 py-2 bg-slate-50 rounded-2xl border border-slate-100">
        @if($report->start_date && $report->end_date)
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                <span class="text-indigo-500 italic">من:</span>
                <span>{{ $report->start_date }}</span>
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-700 border-t border-slate-200 pt-1">
                <span class="text-rose-500 italic">إلى:</span>
                <span>{{ $report->end_date }}</span>
            </div>
        @else
            <span class="text-sm text-slate-500 italic">
                {{ $report->notes ?? 'غير محدد' }}
            </span>
        @endif
    </div>
</td>
                            <td class="px-8 py-5 text-left font-black">
                                <div class="text-emerald-600 text-2xl">
                                    {{ number_format($report->net_amount, 2) }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-bold tracking-tighter"> {{ $report->currency_symbol }} </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>