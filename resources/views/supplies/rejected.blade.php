<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-red-600 leading-tight text-right">الأرشيف: السندات المرفوضة</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-red-50 border-b">
                            <th class="p-3 border text-gray-700">رقم السند</th>
                            <th class="p-3 border text-gray-700">المشروع</th>
                            <th class="p-3 border text-gray-700">المبلغ المرفوض</th>
                            <th class="p-3 border text-gray-700">  تاريخ الرفض والسبب</th>
                            <th class="p-3 border text-gray-700"> الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rejectedSupplies as $supply)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="p-3 border font-bold">{{ $supply->receipt_number }}</td>
                            <td class="p-3 border">{{ $supply->project->project_name }}</td>
                            <td class="p-3 border text-red-600 font-bold">
                                {{ number_format($supply->amount, 2) }} {{ $supply->currency->currency_code }}
                            </td>
                            <td class="p-3 border text-sm text-gray-500">
                                {{ $supply->updated_at->format('Y-m-d') }}
                                / {{ $supply->rejection_reason}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
    
    <form action="{{ route('supplies.resubmit', $supply->id_supply) }}" method="POST" onsubmit="return confirm('هل تريد إعادة إرسال هذا السند للاعتماد مرة أخرى؟')">
        @csrf
        @method('PUT')
        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 shadow-sm text-xs transition">
            إعادة إرسال
        </button>
    </form>

    <form action="{{ route('supplies.destroy', $supply->id_supply) }}" method="POST" onsubmit="return confirm('تحذير: سيتم حذف السند وكافة التقارير المرتبطة به نهائياً. هل أنت متأكد؟')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 shadow-sm text-xs transition">
            حذف نهائي
        </button>
    </form>

    @if($supply->status == 'rejected')
    <a href="{{ route('supplies.edit', $supply->id_supply) }}" 
       class="text-indigo-600 hover:text-indigo-900 font-bold">
       📝 تعديل وإعادة إرسال
    </a>
@endif

</td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400">لا توجد سندات مرفوضة.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>