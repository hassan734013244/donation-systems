<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">طلبات الاعتماد المعلقة</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 border">رقم السند</th>
                            <th class="p-3 border">المشروع</th>
                            <th class="p-3 border">المبلغ</th>
                            <th class="p-3 border">الصافي</th>
                            <th class="p-3 border">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingSupplies as $supply)
                        <tr>
                            <td class="p-3 border">{{ $supply->receipt_number }}</td>
                            <td class="p-3 border">{{ $supply->project->project_name }}</td>
                            <td class="p-3 border font-bold">{{ number_format($supply->amount, 2) }} {{ $supply->currency->symbol }}</td>
                            <td class="p-3 border text-green-600 font-bold">{{ number_format($supply->net_amount, 2) }}</td>
                            <td class="p-3 border">
                                <form action="{{ route('approvals.store', $supply->id_supply) }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="bg-green-500 text-white px-3 py-1 rounded text-sm">موافقة</button>
                                </form>
                                <form action="{{ route('approvals.store', $supply->id_supply) }}" method="POST" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">رفض</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>