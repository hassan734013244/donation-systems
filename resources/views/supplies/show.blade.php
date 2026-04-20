<x-app-layout>
    <div class="py-8" dir="rtl">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6 no-print">
                <h2 class="text-2xl font-bold text-gray-800">تفاصيل سند التوريد رقم: {{ $supply->receipt_number }}</h2>
                <div class="flex gap-2">
                    <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg shadow hover:bg-black transition">
                        🖨️ طباعة السند
                    </button>
                    <a href="{{ route('reports.supplies') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50">
                        عودة للخلف
                    </a>

                    @php
        $shareUrl = URL::signedRoute('supplies.public_show', ['id' => $supply->id_supply]);
    @endphp
    <button onclick="copyLink('{{ $shareUrl }}')" class="bg-emerald-600 text-white px-4 py-2 rounded-lg shadow hover:bg-emerald-700 transition">
        🔗 نسخ رابط المتبرع
    </button>
                </div>

              

    
    
    
   

            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 mb-6">
             <div class="flex justify-between items-center bg-gray-50 border rounded-lg px-4 py-3">

    <!-- المشروع -->
    <div>
        <p class="text-[11px] text-gray-500 mb-1">المشروع</p>
        <h3 class="text-base font-semibold text-gray-800">
            {{ $supply->project->project_name }}
        </h3>
    </div>

    <!-- الحالة -->
    <div class="text-left">
        <p class="text-[11px] text-gray-500 mb-1">حالة السند</p>

        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
            {{ $supply->status == 'approved' ? 'bg-green-100 text-green-700' : '' }}
            {{ $supply->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
            {{ $supply->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}
        ">
            {{ $supply->status }}
        </span>
    </div>

</div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-blue-600 text-sm font-bold mb-1">المبلغ الصافي</p>
                        <h4 class="text-2xl font-black text-blue-900">{{ number_format($supply->net_amount, 2) }} <span class="text-sm">{{ $supply->currency->symbol }}</span></h4>
                    </div>
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100">
    <p class="text-red-600 text-sm font-bold mb-1">إجمالي مصروفات المشروع حتى الآن</p>
    <h4 class="text-2xl font-black text-red-900">
        {{ number_format($spent_from_this_supply, 2) }} <span class="text-sm">{{ $supply->currency->symbol }}</span>
    </h4>
</div>
                    <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                        <p class="text-green-600 text-sm font-bold mb-1">الرصيد المتبقي</p>
                        <h4 class="text-2xl font-black text-green-900">{{ number_format($remaining_balance, 2) }} <span class="text-sm">{{ $supply->currency->symbol }}</span></h4>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <p class="text-gray-600 text-sm font-bold mb-1">نهاية المشروع</p>
                        <h4 class="text-lg font-bold text-gray-800 italic">
                            {{ $supply->project->is_continuous ? 'مستمر طوال العام' : $supply->project->end_date }}
                        </h4>
                    </div>
                </div>

                
            </div>

            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-1 bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
                    <h4 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                        <span class="ml-2">🖼️</span> المعاينة المستندية (المرفقات)
                    </h4>
                   <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
    @forelse($supply->attachments as $file)
        <div class="relative group border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
            {{-- تعديل الشرط: تحويل الامتداد لحروف صغيرة قبل الفحص لضمان قبول JPG و jpg --}}
            @if(in_array(strtolower($file->file_type), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <a href="{{ asset($file->file_path) }}" target="_blank" class="block">
                    <img src="{{ asset($file->file_path) }}" 
                         class="h-32 w-full object-cover" 
                         alt="صورة المرفق"
                         onerror="this.src='https://placehold.co/300x200?text=Image+Not+Found';">
                </a>
            @else
                {{-- عرض الملفات غير الصورية (مثل PDF) --}}
                <a href="{{ asset($file->file_path) }}" target="_blank" class="h-32 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition">
                    <span class="text-4xl">📄</span>
                    <span class="text-[10px] mt-2 px-2 text-center text-gray-600 truncate w-full">{{ $file->file_name }}</span>
                </a>
            @endif
        </div>
    @empty
        <p class="text-gray-400 text-sm col-span-3 text-center py-10 italic">لا توجد مرفقات لهذا السند</p>
    @endforelse
</div>>
                </div>

               <div class="md:col-span-2 bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
    <h4 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center justify-between">
        <span>📅 جدول التقارير المطلوبة</span>
    </h4>
    <div class="space-y-4">
        @foreach($supply->reports as $report)
            <div class="flex items-center justify-between p-3 rounded-lg {{ $report->status == 'completed' ? 'bg-green-50 border border-green-100' : 'bg-orange-50 border border-orange-100' }}">
                <div class="flex items-start gap-3">
                    <div class="mt-1">
                        @if($report->status == 'completed') 
                            <span class="text-green-600">✅</span> 
                        @else 
                            <span class="text-orange-600 animate-pulse">⏳</span> 
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $report->report_title }}</p>
                        <p class="text-[10px] text-gray-500 italic">تاريخ الاستحقاق: {{ $report->due_date }}</p>
                    </div>
                </div>

                <div>
                    @if($report->status == 'completed' && $report->report_file)
    {{-- زر المعاينة --}}
    <a href="{{ asset($report->report_file) }}" 
       target="_blank" 
       class="inline-flex items-center gap-1 text-[10px] bg-green-600 border border-green-500 text-white px-3 py-1.5 rounded-full hover:bg-green-700 hover:shadow-md transition-all">
        <span>👁️</span> معاينة التقرير
    </a>
@else
    {{-- زر الرفع --}}
    <button onclick="openUploadModal({{ $report->id_report }}, '{{ $report->report_title }}')" 
            class="inline-flex items-center gap-1 bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-indigo-700 shadow-md transition-all no-print">
        <span>📤</span> إكمال وإرفاق ملف
    </button>
@endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<div id="uploadModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-md transition-opacity"></div>

    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <div id="modalContent" class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all sm:my-8 opacity-0 translate-y-4 scale-95">
            
            <div class="bg-gradient-to-r from-indigo-600 to-blue-700 p-6 text-white text-right relative">
                <h3 id="modalTitle" class="text-xl font-extrabold flex items-center gap-2">
                    <span class="bg-white bg-opacity-20 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </span>
                    إرفاق تقرير الإنجاز
                </h3>
                <button onclick="closeUploadModal()" class="absolute top-4 left-4 text-white hover:rotate-90 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="uploadForm" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3 text-right">يرجى اختيار ملف التقرير النهائي:</label>
                    
                    <div class="relative group">
                        <input type="file" name="report_file" id="fileInput" required 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                               onchange="updateFileName(this)">
                        
                        <div id="dropzone" class="border-2 border-dashed border-gray-300 rounded-2xl py-10 px-4 bg-gray-50 group-hover:bg-indigo-50 group-hover:border-indigo-400 transition-all duration-300 text-center">
                            <div id="uploadIcon" class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <p id="fileNameDisplay" class="text-sm font-medium text-gray-600">اسحب الملف هنا أو انقر للاختيار</p>
                            <p class="text-xs text-gray-400 mt-2">PDF, PNG, JPG (الحد الأقصى 5MB)</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-green-700 hover:shadow-xl active:scale-95 transition-all flex items-center justify-center gap-2">
                        <span>✅</span> اعتماد وإرسال للمتبرع
                    </button>
                    <button type="button" onclick="closeUploadModal()" class="w-full py-3 text-gray-500 font-semibold hover:text-gray-700 transition">
                        إلغاء العملية
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openUploadModal(reportId, title) {
    const modal = document.getElementById('uploadModal');
    const content = document.getElementById('modalContent');
    
    document.getElementById('modalTitle').innerText = "رفع: " + title;
    document.getElementById('uploadForm').action = "/reports/complete/" + reportId;
    
    modal.classList.remove('hidden');
    
    // تأخير بسيط لتفعيل الـ Animation
    setTimeout(() => {
        content.classList.remove('opacity-0', 'translate-y-4', 'scale-95');
        content.classList.add('opacity-100', 'translate-y-0', 'scale-100');
    }, 10);

    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    const content = document.getElementById('modalContent');
    
    content.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
    content.classList.add('opacity-0', 'translate-y-4', 'scale-95');
    
    setTimeout(() => {
        document.getElementById('uploadModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        // إعادة تعيين شكل الفورم
        document.getElementById('uploadForm').reset();
        document.getElementById('fileNameDisplay').innerText = "اسحب الملف هنا أو انقر للاختيار";
    }, 300);
}

// لتغيير النص عند اختيار ملف
function updateFileName(input) {
    const display = document.getElementById('fileNameDisplay');
    if (input.files.length > 0) {
        display.innerText = "تم اختيار: " + input.files[0].name;
        display.classList.add('text-indigo-600', 'font-bold');
        document.getElementById('dropzone').classList.add('bg-indigo-50', 'border-indigo-400');
    }
}
</script>

                
            </div>

            <div class="mt-8 bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h4 class="font-bold text-gray-800 flex items-center">
            <span class="ml-2 text-xl">💸</span> تفاصيل المبالغ المصروفة من هذا السند
        </h4>
        <span class="bg-rose-100 text-rose-700 text-xs font-bold px-3 py-1 rounded-full">
            إجمالي العمليات: {{ $disbursements->count() }}
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="text-gray-400 text-xs uppercase tracking-wider border-b">
                    <th class="px-6 py-4 font-black">اسم المستفيد</th>
                    <th class="px-6 py-4 font-black text-center">المبلغ المصروف</th>
                    <th class="px-6 py-4 font-black text-center">تاريخ العملية</th>
                    <th class="px-6 py-4 font-black text-center">البيان (مقابل)</th>
                    <th class="px-6 py-4 font-black text-left no-print">إجراءات</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($disbursements as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                
                                <span class="text-sm font-bold text-gray-700">{{ $item->beneficiary_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-rose-600 font-black text-base">{{ number_format($item->amount, 2) }}</span>
                            <span class="text-[10px] text-gray-400 font-bold mr-1 italic">ريال</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($item->disbursement_date)->format('Y-m-d') }}
                            </span>
                        </td>
  
<td class="px-6 py-4">
    <p class="text-xs text-gray-500 leading-relaxed max-w-xs italic">
        {{ $item->statement }}
    </p>
</td>

                      <td class="px-6 py-4 text-left no-print">
    <div class="flex items-center justify-end gap-2">

        <form action="{{ route('disbursements.destroy', $item->id_disbursement) }}" method="POST" 
              onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف عملية الصرف هذه؟ سيتم استعادة المبلغ للرصيد المتاح.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-rose-400 hover:text-rose-600 transition p-1" title="حذف">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>
    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2">📥</span>
                                <p class="text-gray-400 italic">لا توجد عمليات صرف مسجلة لهذا السند حتى الآن.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

            <div class="mt-6 bg-white shadow-lg rounded-2xl p-6 border border-gray-100">
                <h4 class="font-bold text-gray-800 mb-2 border-b pb-2">📝 تفاصيل البيان والملاحظات</h4>
                <div class="p-4 bg-gray-50 rounded-xl italic text-gray-700 leading-relaxed">
                    {{ $supply->statement }}
                </div>
            </div>

            @if($supply->status == 'pending')
   <div class="mt-8 p-6 bg-white shadow-lg rounded-2xl border-t-4 border-orange-400 no-print">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-right">
            <h4 class="font-bold text-gray-800 text-lg">اتخاذ قرار بشأن هذا السند</h4>
            <p class="text-sm text-gray-500">يرجى مراجعة كافة البيانات والمرفقات قبل الاعتماد أو الرفض.</p>
        </div>
        
        <div class="flex flex-col gap-3 w-full md:w-auto">
            
            <form action="{{ route('supplies.approve', $supply->id_supply) }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full md:min-w-[180px] h-[48px] inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-8 rounded-xl font-bold transition shadow-md hover:shadow-lg">
                    <span class="ml-2 text-lg">✅</span> اعتماد السند
                </button>
            </form>

            <button type="button" onclick="toggleRejectModal()" class="w-full md:min-w-[180px] h-[48px] inline-flex items-center justify-center bg-red-500 hover:bg-red-600 text-white px-8 rounded-xl font-bold transition shadow-md hover:shadow-lg">
                <span class="ml-2 text-lg">❌</span> رفض السند
            </button>
            
        </div>
    </div>
</div>
            @endif

        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="toggleRejectModal()"></div>
            <div class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('supplies.reject', $supply->id_supply) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-bold text-red-600 mb-4">سبب عدم الاعتماد (الرفض)</h3>
                        <textarea name="rejection_reason" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" placeholder="اكتب السبب هنا..." required></textarea>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-row-reverse gap-2">
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md font-bold hover:bg-red-700">تأكيد الرفض</button>
                        <button type="button" onclick="toggleRejectModal()" class="bg-white text-gray-700 border px-4 py-2 rounded-md font-bold hover:bg-gray-50">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleRejectModal() {
            document.getElementById('rejectModal').classList.toggle('hidden');
        }
    </script>

    <style>
        @media print {
            .no-print, nav, footer { display: none !important; }
            .bg-white { box-shadow: none !important; border: none !important; }
            .bg-indigo-600 { background-color: #4f46e5 !important; -webkit-print-color-adjust: exact; }
            body { background: white !important; }
            .max-w-6xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; }
        }
    </style>

    <script>
function copyLink(url) {
    navigator.clipboard.writeText(url);
    alert('تم نسخ رابط المشاركة بنجاح! يمكنك إرساله للمتبرع الآن.');
}
</script>
</x-app-layout>