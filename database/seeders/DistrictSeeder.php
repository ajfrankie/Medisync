<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['name' => 'Colombo', 'province' => 'Western Province'],
            ['name' => 'Gampaha', 'province' => 'Western Province'],
            ['name' => 'Kalutara', 'province' => 'Western Province'],
            ['name' => 'Kandy', 'province' => 'Central Province'],
            ['name' => 'Matale', 'province' => 'Central Province'],
            ['name' => 'Nuwara Eliya', 'province' => 'Central Province'],
            ['name' => 'Galle', 'province' => 'Southern Province'],
            ['name' => 'Matara', 'province' => 'Southern Province'],
            ['name' => 'Hambantota', 'province' => 'Southern Province'],
            ['name' => 'Jaffna', 'province' => 'Northern Province'],
            ['name' => 'Kilinochchi', 'province' => 'Northern Province'],
            ['name' => 'Mannar', 'province' => 'Northern Province'],
            ['name' => 'Vavuniya', 'province' => 'Northern Province'],
            ['name' => 'Mullaitivu', 'province' => 'Northern Province'],
            ['name' => 'Batticaloa', 'province' => 'Eastern Province'],
            ['name' => 'Ampara', 'province' => 'Eastern Province'],
            ['name' => 'Trincomalee', 'province' => 'Eastern Province'],
            ['name' => 'Kurunegala', 'province' => 'North Western Province'],
            ['name' => 'Puttalam', 'province' => 'North Western Province'],
            ['name' => 'Anuradhapura', 'province' => 'North Central Province'],
            ['name' => 'Polonnaruwa', 'province' => 'North Central Province'],
            ['name' => 'Badulla', 'province' => 'Uva Province'],
            ['name' => 'Monaragala', 'province' => 'Uva Province'],
            ['name' => 'Ratnapura', 'province' => 'Sabaragamuwa Province'],
            ['name' => 'Kegalle', 'province' => 'Sabaragamuwa Province'],
        ];

        foreach ($districts as $district) {
            District::create([
                'id' => (string) Str::uuid(),
                'name' => $district['name'],
                'province' => $district['province'],
            ]);
        }
    }
}
