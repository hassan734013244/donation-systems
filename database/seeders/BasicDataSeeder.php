<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Currency;
use App\Models\Project;

class BasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. إنشاء فرع
        Branch::create([
            'branch_name' => 'المركز الرئيسي', 
            'location' => 'صنعاء'
        ]);

        // 2. إنشاء العملات
        Currency::create([
            'currency_code' => 'USD', 
            'currency_name' => 'دولار أمريكي', 
            'symbol' => '$', 
            'is_default' => true
        ]);
        
        Currency::create([
            'currency_code' => 'YER', 
            'currency_name' => 'ريال يمني', 
            'symbol' => '﷼', 
            'is_default' => false
        ]);

        // 3. إنشاء مشروع تجريبي
        Project::create([
            'project_name' => 'مشروع إفطار الصائم 2026',
            'description' => 'توزيع وجبات إفطار للأسر المحتاجة',
            'start_date' => now(),
            'status' => 'active'
        ]);
    }
}