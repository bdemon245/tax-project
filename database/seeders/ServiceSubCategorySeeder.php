<?php

namespace Database\Seeders;

use App\Models\ServiceSubCategory;
use Illuminate\Database\Seeder;

class ServiceSubCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categories = [
            1 => [
                'Income Tax',
                'Company & Audit',
                'VAT',
                'Registration & License',
            ],
            2 => [
                'VAT Registration',
            ],
            3 => [
                'RJSC Company Registration',
                'Partnership Registration',
                'Export Registration Certificate',
                'Import Registration Certificate',
                'Trade License(CCC)',
            ],
        ];

        foreach ($categories as $key => $subs) {
            foreach ($subs as $name) {
                ServiceSubCategory::create([
                    'service_category_id' => $key,
                    'name' => $name,
                    'description' => fake()->realText(),
                    'image' => picsum($name),
                ]);
            }
        }
    }
}
