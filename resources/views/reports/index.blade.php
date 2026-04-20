<x-app-layout>
    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-wrap md:flex-nowrap gap-4 mb-6" dir="rtl">
    
    <div class="flex-1 min-w-[200px] bg-white rounded-xl shadow-sm p-4 border-r-4 border-blue-500">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold">إجمالي الالتزامات</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $stats['total'] }}</h3>
            </div>
        </div>
    </div>

    <div class="flex-1 min-w-[200px] bg-white rounded-xl shadow-sm p-4 border-r-4 border-green-500">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-green-50 rounded-lg text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold">تم التسليم ({{ $completionRate }}%)</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $stats['completed'] }}</h3>
            </div>
        </div>
    </div>

    <div class="flex-1 min-w-[200px] bg-white rounded-xl shadow-sm p-4 border-r-4 border-red-500">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-50 rounded-lg text-red-600">
                <svg xmlns="http://www.w3.org/2000/Point" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold">تقارير متأخرة</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $stats['overdue'] }}</h3>
            </div>
        </div>
    </div>

    <div class="flex-1 min-w-[200px] bg-white rounded-xl shadow-sm p-4 border-r-4 border-yellow-500">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold">قيد الانتظار</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $stats['pending'] }}</h3>
            </div>
        </div>
    </div>

</div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border-t-4 border-indigo-500">
                <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end text-right">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">المشروع</label>
                        <select name="project_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                            <option value="">كل المشاريع</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id_project }}" {{ request('project_id') == $project->id_project ? 'selected' : '' }}>
                                    {{ $project->project_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">الحالة</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">كل الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>متأخر</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>تم التسليم</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md shadow-lg border-2 border-blue-700">تطبيق الفلتر</button>
                    </div>
                    <div>
                        <a href="{{ route('reports.index') }}" class="block text-center text-gray-500 text-sm underline">إعادة تعيين</a>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                            <th class="py-3 px-6">عنوان التقرير</th>
                            <th class="py-3 px-6">المشروع</th>
                            <th class="py-3 px-6">الإدارة</th>
                            <th class="py-3 px-6 text-center">تاريخ الاستحقاق</th>
                            <th class="py-3 px-6 text-center">الحالة</th>
                            <th class="py-3 px-6 text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($reports as $report)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 font-bold">{{ $report->report_title }}</td>
                                <td class="py-3 px-6 text-xs">{{ $report->project->project_name ?? '---' }} / 
    {{ $report->supply->donor->donor_name ?? 'بدون متبرع' }}</td>
                                <td class="py-3 px-6 text-xs">{{ $report->supply->department->name_department ?? '---' }}</td>
                                <td class="py-3 px-6 text-center font-mono">{{ $report->due_date }}</td>
                                <td class="py-3 px-6 text-center">
                                    @if($report->status == 'overdue')
                                        <span class="bg-red-100 text-red-600 py-1 px-3 rounded-full text-xs">متأخر</span>
                                    @elseif($report->status == 'completed')
                                        <span class="bg-green-100 text-green-600 py-1 px-3 rounded-full text-xs">تم التسليم</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-600 py-1 px-3 rounded-full text-xs">قيد الانتظار</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    @if($report->status != 'completed')
                                        
                                            @csrf @method('PATCH')
                                            <button onclick="openUploadModal({{ $report->id_report }}, '{{ $report->report_title }}')" class="text-green-600 hover:text-green-900 font-bold">تحديد كمكتمل</button>
                                        
                                       
                                    @else
                                        <span class="text-gray-400">✅ تم الإنجاز</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-500 italic">لا توجد تقارير مطابقة للبحث.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                
                <div class="p-4 bg-gray-50">
                    {{ $reports->links() }}
                </div>
            </div>
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
</x-app-layout>

