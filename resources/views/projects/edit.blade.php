<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">تعديل بيانات المشروع</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('projects.index') }}" class="text-blue-600 hover:text-blue-800 font-bold flex items-center gap-2">
                    <span>➡️</span> العودة لقائمة المشاريع
                </a>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-amber-500">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="bg-amber-100 text-amber-600 p-2 rounded-lg ml-3">✏️</span>
                    تعديل: {{ $project->project_name }}
                </h3>

                <form action="{{ route('projects.update', $project->id_project) }}" method="POST">
                    @csrf
                    @method('PATCH') {{-- أو PUT حسب ما عرفته في المسارات --}}
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="md:col-span-2">
                            <label class="block font-semibold text-gray-700 mb-2">اسم المشروع</label>
                            <input type="text" name="project_name" value="{{ $project->project_name }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">الحالة</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="on_hold" {{ $project->status == 'on_hold' ? 'selected' : '' }}>متوقف مؤقتاً</option>
                                <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">تاريخ البدء</label>
                            <input type="date" name="start_date" value="{{ $project->start_date }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-700 mb-2">تاريخ الانتهاء</label>
                            <input type="date" name="end_date" value="{{ $project->end_date }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8">
                        <a href="{{ route('projects.index') }}" class="bg-danger-120 text-gray-600 font-bold px-6 py-3 rounded-none hover:bg-gray-200 transition">
                            إلغاء
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-none shadow-lg transition-all transform hover:scale-120">
                            تحديث البيانات ✓
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>