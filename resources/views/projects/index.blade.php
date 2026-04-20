<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">إدارة المشاريع</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- فورم إضافة مشروع جديد --}}
            <div class="bg-white p-8 rounded-xl shadow-lg mb-8 border-t-4 border-blue-600">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-lg ml-3">➕</span>
                    إضافة مشروع جديد ونظام التقارير
                </h3>

                <form action="{{ route('projects.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="md:col-span-2">
                            <label class="block font-semibold text-gray-700 mb-2">اسم المشروع</label>
                            <input type="text" name="project_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="أدخل اسم المشروع هنا" required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">الحالة</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="active">نشط</option>
                                <option value="on_hold">متوقف مؤقتاً</option>
                                <option value="completed">مكتمل</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">تاريخ البدء</label>
                            <input type="date" name="start_date" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">تاريخ الانتهاء</label>
                            <input type="date" name="end_date" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-none shadow-lg transition-all transform hover:scale-105">
                            حفظ المشروع والجدولة ✓
                        </button>
                    </div>
                </form>
            </div>

            {{-- قائمة المشاريع --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700">قائمة المشاريع الحالية</div>
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold">
                            <th class="py-4 px-6">اسم المشروع</th>
                            <th class="py-4 px-6 text-center">الحالة</th>
                            <th class="py-4 px-6 text-center">الفترة الزمنية</th>
                            <th class="py-4 px-6 text-center">تغيير الحالة</th>
                            <th class="py-4 px-6 text-left">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($projects as $project)
                        <tr class="border-b border-gray-100 hover:bg-blue-50 transition">
                            <td class="py-4 px-6">
                                <div class="font-bold text-blue-900">{{ $project->project_name }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold 
                                    {{ $project->status == 'active' ? 'bg-green-100 text-green-700' : 
                                       ($project->status == 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700') }}">
                                    {{ $project->status == 'active' ? 'نشط' : ($project->status == 'completed' ? 'مكتمل' : 'متوقف') }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center text-xs">
                                <span class="text-gray-400">من:</span> {{ $project->start_date }} <br>
                                <span class="text-gray-400">إلى:</span> {{ $project->end_date }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('projects.update_status', $project->id_project) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-[10px] border-gray-200 rounded-lg py-1 focus:ring-blue-500">
                                        <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>تنشيط</option>
                                        <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>إكمال</option>
                                        <option value="on_hold" {{ $project->status == 'on_hold' ? 'selected' : '' }}>إيقاف</option>
                                    </select>
                                </form>
                            </td>
                          <td class="py-4 px-6 text-left">
    <div class="flex justify-start gap-2">
        {{-- زر التعديل --}}
        <a href="{{ route('projects.edit', $project->id_project) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-none hover:bg-indigo-100 transition shadow-sm" title="تعديل">
            ✏️
        </a>

        {{-- زر الحذف المشروط --}}
        @php
            // نتحقق من وجود المشروع في الجداول المرتبطة
            $hasSupplies = DB::table('supplies')->where('id_project', $project->id_project)->exists();
            $hasDonorReports = DB::table('donor_reports')->where('id_project', $project->id_project)->exists();
        @endphp

        @if($hasSupplies || $hasDonorReports)
            {{-- إذا كان مرتبطاً، نظهر قفل الحماية بدل زر الحذف --}}
            <button type="button" class="p-2 bg-gray-100 text-gray-400 rounded-none cursor-not-allowed opacity-50" title="لا يمكن الحذف لارتباطه بسندات">
                🔒
            </button>
        @else
            {{-- إذا كان حراً، نظهر زر الحذف --}}
            <form action="{{ route('projects.destroy', $project->id_project) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف المشروع؟');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-none hover:bg-rose-100 transition shadow-sm" title="حذف">
                    🗑️
                </button>
            </form>
        @endif
    </div>
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>