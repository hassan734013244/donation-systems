<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 border-t-4 border-indigo-500">
                
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="ml-2">📝</span> تعديل بيانات السند
                    </h2>
                    <span class="text-sm bg-gray-100 px-3 py-1 rounded-full text-gray-600">رقم السند: {{ $supply->receipt_number }}</span>
                </div>

                @if($supply->rejection_reason)
                <div class="bg-red-50 border-r-4 border-red-500 p-4 mb-8 rounded-l-lg">
                    <div class="flex items-start">
                        <div class="ml-3 text-red-600">⚠️</div>
                        <div>
                            <p class="text-sm text-red-800 font-bold">ملاحظة الإدارة (سبب الرفض):</p>
                            <p class="text-sm text-red-700 italic mt-1 leading-relaxed">{{ $supply->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('supplies.update', $supply->id_supply) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">المشروع المرتبط</label>
                            <select name="id_project" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @foreach($projects as $project)
                                    <option value="{{ $project->id_project }}" {{ $supply->id_project == $project->id_project ? 'selected' : '' }}>
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">المبلغ (العملة: {{ $supply->currency->currency_name }})</label>
                            <input type="number" step="0.01" name="amount" value="{{ $supply->amount }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ التوريد</label>
                            <input type="date" name="supply_date" value="{{ $supply->supply_date }}" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">البيان (التوضيح المالي)</label>
                            <textarea name="statement" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>{{ $supply->statement }}</textarea>
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-between border-t pt-6">
                        <p class="text-xs text-gray-500 italic">* عند الحفظ، سيعود السند آلياً إلى قائمة "الانتظار" ليقوم المدير باعتماده مرة أخرى.</p>
                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            تحديث وإعادة إرسال ✅
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>