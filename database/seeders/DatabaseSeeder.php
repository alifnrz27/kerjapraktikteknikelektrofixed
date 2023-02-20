<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AcademicYearSeeder::class,
            ActiveSeeder::class,
            MentoringStatusSeeder::class,
            ReportStatusSeeder::class,
            RoleSeeder::class,
            SemesterSeeder::class,
            SubmissionStatusSeeder::class,
            TitleStatusSeeder::class,
            UserSeeder::class,
            ValidEmailSeeder::class,
        ]);
    }
}
