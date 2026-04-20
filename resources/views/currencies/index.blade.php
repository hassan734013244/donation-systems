<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">إدارة العملات وأسعار الصرف</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="mb-6 text-gray-600 border-r-4 border-yellow-500 pr-4">
                    ملاحظة: تُستخدم أسعار الصرف هذه لتحويل المبالغ في التقارير والإحصائيات. يرجى تحديثها عند تغير السوق.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($currencies as $currency)
                    <div class="border rounded-lg p-4 shadow-sm bg-gray-50 flex flex-col items-center">
                        <span class="text-3xl mb-2">{{ $currency->currency_code == 'USD' ? '💵' : ($currency->currency_code == 'SAR' ? '🇸🇦' : '🇾🇪') }}</span>
                        <h3 class="font-bold text-lg">{{ $currency->currency_name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $currency->currency_code }}</p>

                        <form action="{{ route('currencies.update', $currency->id_currency) }}" method="POST" class="w-full">
                            @csrf @method('PATCH')
                            <label class="block text-xs text-gray-400 mb-1">سعر الصرف (مقابل العملة المحلية):</label>
                            <div class="flex gap-2">
                                <input type="number" step="0.01" name="exchange_rate" 
                                       value="{{ $currency->exchange_rate }}" 
                                       class="w-full border-gray-300 rounded text-center">
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">تحديث</button>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>