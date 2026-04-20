<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">إدارة المستخدمين </h2>
    </x-slot>
    <div class="py-12" dir="rtl">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-indigo-100 text-sm font-bold">إجمالي الموظفين</p>
                <h3 class="text-3xl font-extrabold mt-1">{{ $stats['total_users'] }}</h3>
            </div>
            <div class="bg-indigo-400 bg-opacity-30 p-3 rounded-lg text-2xl">👥</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm font-bold">عدد الإدارات</p>
                <h3 class="text-3xl font-extrabold mt-1 text-gray-800">{{ $stats['total_depts'] }}</h3>
            </div>
            <div class="bg-blue-50 p-3 rounded-lg text-2xl text-blue-500">🏢</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm font-bold">مدراء النظام</p>
                <h3 class="text-3xl font-extrabold mt-1 text-gray-800">{{ $stats['admins_count'] }}</h3>
            </div>
            <div class="bg-amber-50 p-3 rounded-lg text-2xl text-amber-500">🛡️</div>
        </div>
    </div>

</div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border mb-6">
                <h3 class="text-lg font-bold mb-4 text-indigo-700 underline">👤 إضافة موظف جديد للنظام</h3>
                <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <input type="text" name="name" placeholder="الاسم الكامل" class="rounded-xl border-gray-300" required>
                    <input type="email" name="email" placeholder="البريد الإلكتروني" class="rounded-xl border-gray-300" required>
                    <input type="password" name="password" placeholder="كلمة المرور" class="rounded-xl border-gray-300" required>
                    
                    <select name="id_department" class="rounded-xl border-gray-300" required>
                        <option value="">اختر الإدارة...</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id_department }}">{{ $dept->name_department }}</option>
                        @endforeach
                    </select>

                    <select name="id_role" class="rounded-xl border-gray-300" required>
                        <option value="">حدد الصلاحية (Role)...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition">
                        حفظ المستخدم
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-2xl overflow-hidden border">
                <table class="w-full text-right">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">الموظف</th>
                            <th class="px-6 py-3">الإدارة</th>
                            <th class="px-6 py-3">الصلاحية</th>
                            <th class="px-6 py-3">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 italic">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-indigo-600">{{ $user->department->name_department ?? 'غير محدد' }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $role->role_name }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4"><span class="text-green-500">نشط</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>