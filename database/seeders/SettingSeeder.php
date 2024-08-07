<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $logo = picsum(fake()->name());
        Setting::create([
            'basic' => [
                'logo' => asset('frontend/assets/images/logo/app.png'),
                'email' => fake()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'whatsapp' => fake()->phoneNumber(),
                'favicon' => picsum('favicon'),
                'address' => fake()->address(),
            ],
            'reference' => [
                'commission' => random_int(5, 30),
                'withdrawal' => 500,
                'partner_commission' => 15,
            ],
            'payment' => [
                [
                    'method' => 'bkash',
                    'number' => fake()->phoneNumber(),
                ],
                [
                    'method' => 'nagad',
                    'number' => fake()->phoneNumber(),
                ],
                [
                    'method' => 'rocket',
                    'number' => fake()->phoneNumber(),
                ],
            ],
            'return_links' => [
                [
                    'title' => fake()->realText(10),
                    'link' => fake()->url(),
                ],
                [
                    'title' => fake()->realText(10),
                    'link' => fake()->url(),
                ],
            ],
        ]);
    }
}
