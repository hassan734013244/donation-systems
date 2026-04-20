<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">إدارة المتبرعين</h2>
    </x-slot>

    <div class="py-12 text-right" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
           

            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-t-4 border-indigo-500">
    <form action="{{ route('donors.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">اسم المتبرع / الجهة</label>
                <input type="text" name="donor_name" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                       placeholder="مثلاً: فاعل خير" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">نوع المتبرع</label>
                <select name="donor_type" 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="organization">منظمة / جهة</option>
                    <option value="individual">فرد</option>
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md shadow-lg border-2 border-blue-700">
    حفظ المتبرع الجديد +
</button>
            </div>

        </div>
    </form>
</div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-right">الاسم</th>
                            <th class="p-4 text-right">النوع</th>
                            <th class="p-4 text-right">تاريخ الإضافة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donors as $donor)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium">{{ $donor->donor_name }}</td>
                            <td class="p-4">
                                {{ $donor->donor_type == 'organization' ? 'منظمة' : 'فرد' }}
                            </td>
                            <td class="p-4 text-gray-500 text-sm">
                                {{ $donor->created_at->format('Y-m-d') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>