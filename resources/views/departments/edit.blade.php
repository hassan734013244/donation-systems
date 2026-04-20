<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">تعديل بيانات المشروع</h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('departments.index') }}" class="text-red-600 hover:text-blue-800 font-bold flex items-center gap-4">
                    <span>➡️</span> العودة لقائمة الإدارات
                </a>
            </div>

            
                
                 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                      <h3 class="text-lg font-bold text-gray-800 mb-4">تعديل ادارة</h3>
                         <form action="{{ route('departments.update', $department->id_department ) }}" method="POST" class="flex gap-4">
                          @csrf

                          @method('PUT')
                         <input type="text" name="name_department"  
                           class="flex-1 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required value = "{{ $department->name_department }}">
                          <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-2 rounded-md shadow-lg border-2 border-blue-700">
                          تعديل ({{ $department->name_department  }})
                         </button>
                </form>
                </div>
        </div>


                
    </div>
</x-app-layout>