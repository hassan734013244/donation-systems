<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen" dir="rtl text-right">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-black text-gray-800">السجل العام لسندات التوريد</h2>
                <button onclick="window.print()" class="bg-white border text-gray-600 px-4 py-2 rounded-xl shadow-sm hover:bg-gray-50 no-print">
                    🖨️ طباعة
                </button>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm mb-6 no-print border border-gray-100 ">
                <form action="{{ route('reports.supplies') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-1 ">رقم السند</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث..." class="w-full border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-1">المشروع</label>
                        <select name="project_id" class="w-full border-gray-200 rounded-lg text-sm">
                            <option value="">كل المشاريع</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id_project }}" {{ request('project_id') == $p->id_project ? 'selected' : '' }}>{{ $p->project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-1">الفترة الزمنية</label>
                        <div class="flex gap-1">
                            <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full border-gray-200 rounded-lg text-xs">
                            <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full border-gray-200 rounded-lg text-xs">
                        </div>
                    </div>
                    <div class="flex items-end gap-1">
                        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md shadow-lg border-2 border-blue-700">تطبيق</button>
                        <a href="{{ route('reports.supplies') }}" class="bg-gray-100 text-gray-500 px-3 py-2 rounded-lg hover:bg-gray-200 text-center">🔄</a>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
                <table class="w-full text-right">
                    <thead class="bg-gray-50 border-b">
                        <tr class="text-gray-400 text-xs font-bold italic">
                            <th class="px-6 py-4">رقم السند</th>
                            <th class="px-6 py-4">المتبرع/المشروع</th>
                            <th class="px-6 py-4">الإدارة</th>
                            <th class="px-6 py-4">المبلغ</th>
                            <th class="px-6 py-4 text-center">التاريخ</th>
                            <th class="px-6 py-4 text-left no-print">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($supplies as $report)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-indigo-600">#{{ $report->receipt_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $report->project_name ?? '---' }} / {{ $report->donor_full_name ?? 'بدون متبرع' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $report->name_department ?? '---' }}</td>
                            <td class="px-6 py-4 font-black">
                                {{ number_format($report->net_amount, 2) }} 
                                <span class="text-[10px] text-gray-400 font-bold mr-1">{{ $report->currency_symbol }}</span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-500 text-xs font-medium">{{ $report->supply_date }}</td>
                            <td class="px-6 py-4 text-left no-print">
                                <a href="{{ route('supplies.show', $report->id_supply) }}" class="text-indigo-500 hover:underline text-xs font-bold">التفاصيل</a>
                            

                                
                            
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic text-sm">لا توجد بيانات مطابقة للبحث</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t bg-gray-50">
                    {{ $supplies->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>