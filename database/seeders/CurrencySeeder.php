<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Currency::insert([
        [
            'currency_code' => 'YER',
            'currency_name' => 'ريال يمني',
            'symbol' => 'ر.ي',
            'is_default' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'currency_code' => 'SAR',
            'currency_name' => 'ريال سعودي',
            'symbol' => 'ر.س',
            'is_default' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'currency_code' => 'USD',
            'currency_name' => 'دولار أمريكي',
            'symbol' => '$',
            'is_default' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}
}
