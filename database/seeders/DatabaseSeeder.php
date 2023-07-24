<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Calendar;
use App\Models\CaseStudyPage;
use App\Models\ExpertProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            BannerSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            AppointmentSeeder::class,
            InfoSeeder::class,
            TestimonialSeeder::class,
            SocialHandleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            ClientSeeder::class,
            ClientStudioSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSubCategorySeeder::class,
            ServiceSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            MapSeeder::class,
            BookSeeder::class,
            CaseStudyPackageSeeder::class,
            ExpertProfileSeeder::class,
            CourseSeeder::class,
            CalendarSeeder::class,
        ]);
    }
}
