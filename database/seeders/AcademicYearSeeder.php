<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $academicYear = [
            [
                'id'    => 1,
                'semester_id' => 2,
                'year'=>'2023/2022',
                'is_active' => 0,
                'created_at' => now()
            ],
            [
                'id'    => 2,
                'semester_id' => 1,
                'year'=>'2022/2023',
                'is_active' => 1,
                'created_at' => now()
            ],
        ];

        AcademicYear::insert($academicYear);
    }
}
