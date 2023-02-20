<?php

namespace Database\Seeders;

use App\Models\TitleStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'id'    => 1,
                'name' => 'Sedang diajukan',
            ],
            [
                'id'    => 2,
                'name' => 'Ditolak',
            ],
            [
                'id'    => 3,
                'name' => 'Diterima',
            ],
        ];

        TitleStatus::insert($status);
    }
}
