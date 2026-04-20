<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-r-4 border-red-500 text-red-700 shadow-sm text-right">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-lg p-8 border-t-8 border-indigo-600">
                <h2 class="text-2xl font-bold mb-6 border-b pb-4 text-indigo-600 flex items-center justify-between">
                    <span>تسجيل سند توريد مالي</span>
                    <span class="text-sm bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full">جديد</span>
                </h2>
                
                <form action="{{ route('supplies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-right">
                        
                        <div>
                            <label class="block font-bold mb-1 text-gray-700">رقم السند</label>
                            <input type="text" name="receipt_number" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-gray-700">تاريخ التوريد</label>
                            <input type="date" name="supply_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-gray-700">العملة</label>
                            <select name="id_currency" class="w-full border-gray-300 rounded focus:ring-indigo-500" required>
                                @foreach($currencies as $curr)
                                    <option value="{{ $curr->id_currency }}">{{ $curr->currency_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 shadow-inner">
                            <label class="block font-bold mb-1 text-blue-800">إجمالي المبلغ</label>
                            <input type="number" step="0.01" name="amount" class="w-full border-blue-300 rounded font-bold text-lg text-blue-900" placeholder="0.00" required>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block font-bold mb-1 text-gray-600">نسبة الإدارة (%)</label>
                            <input type="number" step="0.1" name="admin_ratio" value="0" class="w-full border-gray-300 rounded">
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block font-bold mb-1 text-gray-600">نسب أخرى (%)</label>
                            <input type="number" step="0.1" name="other_ratio" value="0" class="w-full border-gray-300 rounded">
                        </div>

                        <div class="md:col-span-2 text-right">
                            <label class="block font-bold mb-1 text-gray-700">المشروع</label>
                            <select name="id_project" class="w-full border-gray-300 rounded focus:ring-indigo-500" required>
                                @foreach($projects as $proj)
                                    <option value="{{ $proj->id_project }}">{{ $proj->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-gray-700">المتبرع</label>
                            <select name="id_donor" class="w-full border-gray-300 rounded focus:ring-indigo-500" required>
                                @foreach($donors as $don)
                                    <option value="{{ $don->id_donor }}">{{ $don->donor_name }}</option>
                                @endforeach
                            </select>
                        </div>
                                     <div >
    <label class="block font-bold mb-1 text-gray-700">الإدارة المختصة:</label>
    <select name="id_department" required 
            class="w-full border-gray-300 rounded focus:ring-indigo-500" required>
        <option value="">-- اختر الإدارة --</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->id_department }}">{{ $dept->name_department }}</option>
        @endforeach
    </select>
</div>
                    </div>
                    
       
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-right" dir="rtl">
    
    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">جهة التوريد (بنك/صندوق)</label>
        <select name="deposit_location" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 shadow-sm text-right h-12">
            <option value="صندوق المؤسسة">صندوق المؤسسة</option>
            <option value="بنك التضامن">بنك التضامن</option>
            <option value="بنك الكريمي">بنك الكريمي</option>
            <option value="بنك اليمن والكويت">بنك اليمن والكويت</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">العدد (كفالات/سلال)</label>
        <input type="number" name="quantity" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 shadow-sm text-center h-12" placeholder="0">
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-2">نسبة التحويل (%)</label>
        <input type="number" step="0.01" name="transfer_ratio" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 shadow-sm text-center h-12" placeholder="0.00">
    </div>

</div>

                    <div class="mt-6 text-right">
                        <label class="block font-bold mb-1 text-gray-700">البيان (Statement)</label>
                        <textarea name="statement" rows="2" class="w-full border-gray-300 rounded focus:ring-indigo-500" placeholder="اكتب تفاصيل السند هنا..." required></textarea>
                    </div>

                    <div class="mt-4 text-right">
                        <label class="block font-bold mb-1 text-gray-400">ملاحظات إضافية</label>
                        <textarea name="notes" rows="1" class="w-full border-gray-300 rounded text-sm focus:ring-gray-400"></textarea>
                    </div>

                    <div class="mt-6 text-right bg-indigo-50 p-4 rounded-xl border border-indigo-100">
    <label class="block font-bold mb-2 text-indigo-700">
        <span class="ml-2">📎</span> توثيق المرفقات (صور الشيكات / صور الاستلام / فيديو)
    </label>
    <input type="file" name="attachments[]" multiple 
           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 pointer-cursor"
           accept="image/*,video/*,application/pdf">
    <p class="text-xs text-gray-500 mt-2">* يمكنك اختيار أكثر من ملف في وقت واحد (صور أو فيديو أو PDF)</p>
</div>

<div class="bg-blue-50 p-4 rounded-xl border border-blue-200 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-bold text-blue-800 flex items-center text-sm">
            <span class="ml-2 text-lg">📅</span> جدولة تقارير المتبرع لهذا التمويل
        </h4>
        <button type="button" onclick="addReportRow()" 
                class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded-lg transition-all flex items-center shadow-sm">
            <span class="ml-1 font-bold">+</span> إضافة تقرير
        </button>
    </div>
    
    <div id="reports-container" class="space-y-2">
        <div class="report-row flex flex-wrap md:flex-nowrap items-center gap-2 bg-white p-2 rounded-lg border border-gray-200 shadow-sm">
            
           <div class="flex-[4] min-w-[250px]"> 
        <input type="text" name="reports[0][title]" 
               class="w-full text-xs rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-1.5" 
               placeholder="عنوان التقرير">
    </div>

    <div class="flex-1">
        <select name="reports[0][type]" 
                class="w-full text-xs rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-1.5">
            <option value="narrative">إنجاز</option>
            <option value="financial">مالي</option>
            <option value="final">ختامي</option>
        </select>
    </div>

    <div class="flex-1">
        <input type="date" name="reports[0][due_date]" 
               class="w-full text-xs rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 py-1.5">
    </div

            <div class="flex-none">
                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 p-1 hidden remove-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let reportCount = 1;

    function addReportRow() {
        const container = document.getElementById('reports-container');
        const firstRow = container.querySelector('.report-row');
        const newRow = firstRow.cloneNode(true);

        // تحديث الـ Index للأسماء وتفريغ القيم
        newRow.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace(/\[\d+\]/, `[${reportCount}]`);
            el.value = '';
        });

        // إظهار زر الحذف
        const removeBtn = newRow.querySelector('.remove-btn');
        removeBtn.classList.remove('hidden');

        container.appendChild(newRow);
        reportCount++;
    }

    function removeRow(btn) {
        btn.closest('.report-row').remove();
    }
</script>



                    <div class="mt-10 pb-4">
                        <button type="submit" 
                                style="background-color: #4f46e5; color: white; width: 100%; font-weight: bold; padding: 1rem; border-radius: 0.5rem; cursor: pointer; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                            حفظ وتوريد السند المالي ✓
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>