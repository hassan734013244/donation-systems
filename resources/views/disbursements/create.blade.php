<x-app-layout>
<div class="max-w-4xl mx-auto py-10" dir="rtl">
    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-rose-600 to-rose-800 p-8 text-black">
            <h2 class="text-2xl font-black italic">إنشاء سند صرف جديد</h2>
            <p class="text-rose-100 text-xs mt-2 font-bold">يرجى اختيار رقم التوريد المرتبط لضبط الميزانية</p>
        </div>

        <form action="{{ route('disbursements.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-500 mr-2">مرتبط بسند توريد رقم:</label>
                    <select name="id_supply" id="id_supply" class="w-full bg-slate-50 border-none rounded-2xl py-3.5 px-4 font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 transition-all">
                        <option value="">اختر المشروع...</option>
                        @foreach($supplies as $supply)
                          <option value="{{ $supply->id_supply }}">
                             سند رقم: {{ $supply->receipt_number }} | مشروع: {{ $supply->project_name }}
                             </option>                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-500 mr-2">المبلغ المتاح للصرف:</label>
                    <div id="balance_display" class="w-full bg-emerald-50 border-2 border-dashed border-emerald-200 rounded-2xl py-3 px-4 text-emerald-700 font-black text-xl flex items-center justify-between">
                        <span id="remaining_amount">0.00</span>
                        <span class="text-[10px] bg-emerald-200 px-2 py-1 rounded-lg">رصيد متاح</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-500 mr-2">مبلغ الصرف الحالي:</label>
                    <input type="number" name="amount" id="amount_input" step="0.01" class="w-full bg-slate-50 border-none rounded-2xl py-3.5 px-4 font-black text-slate-800 text-xl focus:ring-2 focus:ring-rose-500" placeholder="0.00">
                </div>
                <div class="space-y-2">
    <label class="block text-xs font-black text-slate-500 mr-2">اسم المستفيد (جهة الصرف):</label>
    <input type="text" name="beneficiary_name" required 
           class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 transition-all" 
           placeholder="مثلاً: المورد أحمد، أو الموظف هارون ...">
</div>

                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-500 mr-2">اسم المشروع:</label>
                    <input type="text" id="project_display" readonly class="w-full bg-slate-100 border-none rounded-2xl py-3.5 px-4 font-bold text-slate-400 cursor-not-allowed">
                </div>
            </div>

            <div class="col-span-full space-y-2">
    <label class="block text-xs font-black text-slate-500 mr-2">البيان (مقابل ماذا تم الصرف):</label>
    <textarea name="statement" rows="2" required 
              class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold text-slate-700 focus:ring-2 focus:ring-rose-500 transition-all" 
              placeholder="اكتب تفاصيل الصرف هنا (مثلاً: كفالة حلقة كذا لشهر كذا)..."></textarea>
</div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-rose-100 transition-all duration-300 transform hover:-translate-y-1">
                    اعتماد سند الصرف 📝
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const supplySelect = document.getElementById('id_supply');
    
    if(supplySelect) {
        supplySelect.addEventListener('change', function() {
            const supplyId = this.value;
            const balanceDisplay = document.getElementById('remaining_amount');
            const projectDisplay = document.getElementById('project_display');

            if (supplyId) {
                // استخدام الرابط المطلق لضمان عدم حدوث خطأ في المسارات
                fetch(`${window.location.origin}/get-balance/${supplyId}`)
                    .then(response => {
                        if (!response.ok) throw new Error('سند التوريد غير موجود');
                        return response.json();
                    })
                    .then(data => {
                        // تحديث الأرقام والأسماء
                        balanceDisplay.innerText = new Intl.NumberFormat().format(data.remaining);
                        projectDisplay.value = data.project_name;
                        
                        // تحديث الحد الأقصى للمبلغ
                        document.getElementById('amount_input').max = data.remaining;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        balanceDisplay.innerText = "خطأ في الاتصال";
                    });
            } else {
                balanceDisplay.innerText = "0.00";
                projectDisplay.value = "";
            }
        });
    }
});
</script>