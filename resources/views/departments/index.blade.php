
<x-app-layout>
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-none mb-4 text-right">
        {{ session('error') }}
    </div>
@endif
    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🏢 تسجيل إدارة جديدة</h3>
                <form action="{{ route('departments.store') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="text" name="name_department" placeholder="اسم الإدارة (مثلاً: الإدارة المالية)" 
                           class="flex-1 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                    <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-2 rounded-md shadow-lg border-2 border-blue-700">
                        حفظ الإدارة
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-right border-collapse">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-gray-700 font-bold">اسم الإدارة</th>
                            <th class="px-6 py-4 text-gray-700 font-bold">تاريخ الإضافة</th>
                            <th class="px-6 py-4 text-gray-700 font-bold"> اجراءات</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($departments as $dept)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $dept->name_department }}</td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $dept->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 flex gap-2">
    <form action="{{ route('departments.destroy', $dept->id_department) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الإدارة؟');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
             🗑️ حذف
        </button>
    </form>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-10 text-center text-gray-400 italic">لا توجد إدارات مسجلة بعد</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>