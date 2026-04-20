<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('لوحة التحكم بنظام التبرعات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    
                    
    @php
    // جلب البيانات مباشرة داخل الواجهة
    $myDonations = \App\Models\Supply::where('status', 'approved')
        ->selectRaw('id_currency, SUM(amount) as total')
        ->groupBy('id_currency')
        ->with('currency')
        ->get();

    $myTotalBase = \App\Models\Supply::where('status', 'approved')
        ->sum('net_amount_base_currency');
    @endphp
@can('admin')
    <div class="text-sm font-bold text-gray-500">الإجمالي بالريال اليمني</div>
    <div class="text-3xl font-black text-gray-800">
        {{ number_format($myTotalBase, 2) }} ر.ي
    </div>

    <div class="mt-4 space-y-2">
        @foreach($myDonations as $dn)
            <div class="flex justify-between text-xs">
                <span>{{ $dn->currency->currency_name }}:</span>
                <span class="font-bold">{{ number_format($dn->total, 2) }} {{ $dn->currency->symbol }}</span>
            </div>
        @endforeach
    </div>
@else
<div class="text-sm font-bold text-gray-500">  </div>
    <div class="text-3xl font-black text-gray-800">
       لا تملتلك صلاحية لعرض هذا 
    </div>
@endcan
</div>


                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-sm text-gray-500 uppercase font-bold">توريدات بانتظار الموافقة</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['pending_supplies'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500 uppercase font-bold">المشاريع النشطة</div>
                    <div class="text-3xl font-bold text-gray-800">{{ $stats['active_projects'] }}</div>
                </div>

            </div>
        </div>
    </div>


    <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" dir="rtl">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-r-8 border-red-500">
                <div class="p-4 bg-red-50 border-b border-red-100 flex justify-between items-center">
                    <h3 class="font-bold text-red-800 flex items-center">
                        <span class="ml-2">⚠️</span> تقارير متأخرة التسليم
                    </h3>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $overdueReports->count() }}</span>
                </div>
                <div class="p-6">
                    @forelse($overdueReports as $report)
                        <div class="flex justify-between items-center mb-4 last:mb-0 border-b pb-2 last:border-0 text-right">
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $report->report_title }}</p>
                                <p class="text-xs text-gray-500">{{ $report->project->project_name ?? 'بدون مشروع' }}</p>
                            </div>
                            <div class="text-left">
                                <span class="text-red-600 font-bold text-xs bg-red-50 px-2 py-1 rounded">تاريخ الاستحقاق: {{ $report->due_date }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm text-center py-4 italic">لا توجد تقارير متأخرة حالياً ✅</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-r-8 border-yellow-500">
                <div class="p-4 bg-yellow-50 border-b border-yellow-100 flex justify-between items-center">
                    <h3 class="font-bold text-yellow-800 flex items-center">
                        <span class="ml-2">⏳</span> تقارير تستحق خلال هذا الأسبوع
                    </h3>
                    <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">{{ $upcomingReports->count() }}</span>
                </div>
                <div class="p-6 text-right">
                    @forelse($upcomingReports as $report)
                    <div class="flex justify-between items-center mb-4 last:mb-0 border-b pb-2 last:border-0">
    <div class="text-right">
        <p class="font-bold text-gray-800 text-sm">{{ $report->report_title }} | تاريخ
            {{  $report->due_date  }} </p>
        <p class="text-xs text-gray-500">
            {{ $report->project->project_name ?? 'بدون مشروع' }} | 
            <span class="text-indigo-600">{{ $report->donor->donor_name ?? 'بدون متبرع' }}</span>
            
            
        </p>
    </div>
    
    <div class="flex items-center gap-2">
        
            <button onclick="openUploadModal({{ $report->id_report }}, '{{ $report->report_title }}')"
                class="bg-green-100 hover:bg-green-600 text-green-700 hover:text-white p-1 rounded-full transition duration-300 shadow-sm" title="تحديد كمكتمل">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
       
    </div>
</div>
                        
                    @empty
                        <p class="text-gray-400 text-sm text-center py-4 italic">لا توجد تقارير مستحقة قريباً.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>


</x-app-layout>

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

