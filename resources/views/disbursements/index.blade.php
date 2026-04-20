<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('سجل سندات الصرف') }}
            </h2>
            <a href="{{ route('disbursements.create') }}" class="bg-rose-600 text-white px-4 py-2 rounded-lg text-sm font-bold">
                + إضافة سند جديد
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
               
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b">
                            <th class="p-4 text-slate-600 font-bold">رقم السند</th>
                            <th class="p-4 text-slate-600 font-bold">رقم التوريد</th>
                            <th class="p-4 text-slate-600 font-bold">المبلغ المصروف</th>
                            <th class="p-4 text-slate-600 font-bold">تاريخ الصرف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($disbursements as $disbursement)
                        <tr class="border-b hover:bg-slate-50 transition-colors">
                            <td class="p-4">#{{ $disbursement->id_disbursement }}</td>
                            <td class="p-4">{{ $disbursement->receipt_number }}</td>
                            <td class="p-4 font-bold text-rose-600">{{ number_format($disbursement->amount, 2) }} ريال</td>
                            <td class="p-4 text-slate-500">{{ $disbursement->disbursement_date }}</td>
                       
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $disbursements->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>