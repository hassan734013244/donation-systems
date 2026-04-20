<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">طلبات التوريد بانتظار الاعتماد</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
               <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-3 border text-gray-700">رقم السند</th>
                            <th class="p-3 border text-gray-700">التاريخ</th>
                            <th class="p-3 border text-gray-700">المشروع / المتبرع</th>
                            <th class="p-3 border text-gray-700">المبلغ (العملة)</th>
                            <th class="p-3 border text-gray-700">الصافي (عملة الأساس)</th>
                            <th class="p-3 border text-gray-700">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($supplies as $supply)
                            <tr class="border-b hover:bg-yellow-50 transition">
                                <td class="p-3 font-bold text-indigo-600">{{ $supply->receipt_number }}
                                   



                                </td>
                                <td class="p-3 text-sm">{{ $supply->supply_date }}</td>
                                <td class="p-3">
                                    <div class="font-medium">{{ $supply->project->project_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $supply->donor->donor_name }}</div>
                                </td>
                                <td class="p-3 font-bold text-green-700">
                                    {{ number_format($supply->amount, 2) }} 
                                    <span class="text-xs text-gray-500">{{ $supply->currency->currency_code }}</span>
                                </td>
                                <td class="p-3 font-bold text-blue-800">
                                    {{ number_format($supply->net_amount_base_currency, 2) }}
                                    <span class="text-xs">YER</span>
                                </td>
                                <td class="p-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('approvals.store', $supply->id_supply) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 shadow-sm text-xs transition">
                                                اعتماد ✓
                                            </button>
                                        </form>

                                        <form action="{{ route('approvals.store', $supply->id_supply) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <a href="{{ route('supplies.show', $supply->id_supply) }}" 
   class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
   <span class="ml-1">👁️</span> عرض التفاصيل 
</a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500 font-bold">
                                    لا توجد طلبات توريد معلقة حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>


</x-app-layout>