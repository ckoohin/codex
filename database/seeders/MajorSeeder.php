<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = config('fpt_majors.majors');
        foreach ($majors as $m) {
            Major::updateOrCreate(
                ['code' => $m['code']],
                [
                    'name' => $m['name'],
                    'description' => 'Ngành thuộc chương trình FPT Polytechnic',
                    'tags' => $m['skills'] ?? [],
                    'is_active' => true,
                ]
            );
        }
    }
}
