<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloodtypes = [
            'A+', 
            'A-', 
            'B+', 
            'B-', 
            'AB+', 
            'AB-', 
            'O+', 
            'O-'
        ];

        foreach ($bloodtypes as $bloodType) {
            \App\Models\BloodType::firstOrCreate([
                'name' => $bloodType,
            ]);
        }
    }
}
