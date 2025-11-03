<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\District;
use App\Models\GnDivision;

class GnDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Trincomalee District
        $trinco = District::where('name', 'Trincomalee')->first();
        if ($trinco) {
            $trincoDivisions = [
                ['name' => 'Konesapuri', 'gn_code' => 'TN-001'],
                ['name' => 'Uppuveli', 'gn_code' => 'TN-002'],
                ['name' => 'Sampalthivu', 'gn_code' => 'TN-003'],
                ['name' => 'Anpuvallipuram', 'gn_code' => 'TN-004'],
                ['name' => 'Lingapuram', 'gn_code' => 'TN-005'],
                ['name' => 'China Bay', 'gn_code' => 'TN-006'],
                ['name' => 'Thirukadaloor', 'gn_code' => 'TN-007'],
                ['name' => 'Alles Garden', 'gn_code' => 'TN-008'],
                ['name' => 'Kanniya', 'gn_code' => 'TN-009'],
                ['name' => 'Nilaveli', 'gn_code' => 'TN-010'],
            ];

            foreach ($trincoDivisions as $division) {
                GnDivision::create([
                    'id' => (string) Str::uuid(),
                    'name' => $division['name'],
                    'gn_code' => $division['gn_code'],
                    'district_id' => $trinco->id,
                ]);
            }
        }

        //Colombo District 
        $colombo = District::where('name', 'Colombo')->first();
        if ($colombo) {
            $colomboDivisions = [
                ['name' => 'Kollupitiya', 'gn_code' => 'CO-001'],
                ['name' => 'Bambalapitiya', 'gn_code' => 'CO-002'],
                ['name' => 'Wellawatte', 'gn_code' => 'CO-003'],
                ['name' => 'Kirulapone', 'gn_code' => 'CO-004'],
                ['name' => 'Nugegoda', 'gn_code' => 'CO-005'],
                ['name' => 'Dehiwala', 'gn_code' => 'CO-006'],
                ['name' => 'Mount Lavinia', 'gn_code' => 'CO-007'],
                ['name' => 'Kotte', 'gn_code' => 'CO-008'],
                ['name' => 'Rajagiriya', 'gn_code' => 'CO-009'],
                ['name' => 'Homagama', 'gn_code' => 'CO-010'],
            ];

            foreach ($colomboDivisions as $division) {
                GnDivision::create([
                    'id' => (string) Str::uuid(),
                    'name' => $division['name'],
                    'gn_code' => $division['gn_code'],
                    'district_id' => $colombo->id,
                ]);
            }
        }

        //Jaffna District
        $jaffna = District::where('name', 'Jaffna')->first();
        if ($jaffna) {
            $jaffnaDivisions = [
                ['name' => 'Nallur', 'gn_code' => 'JA-001'],
                ['name' => 'Kopay', 'gn_code' => 'JA-002'],
                ['name' => 'Chunnakam', 'gn_code' => 'JA-003'],
                ['name' => 'Navanthurai', 'gn_code' => 'JA-004'],
                ['name' => 'Kokuvil', 'gn_code' => 'JA-005'],
                ['name' => 'Thirunelvely', 'gn_code' => 'JA-006'],
                ['name' => 'Pungudutivu', 'gn_code' => 'JA-007'],
                ['name' => 'Velanai', 'gn_code' => 'JA-008'],
                ['name' => 'Karainagar', 'gn_code' => 'JA-009'],
                ['name' => 'Delft', 'gn_code' => 'JA-010'],
            ];

            foreach ($jaffnaDivisions as $division) {
                GnDivision::create([
                    'id' => (string) Str::uuid(),
                    'name' => $division['name'],
                    'gn_code' => $division['gn_code'],
                    'district_id' => $jaffna->id,
                ]);
            }
        }
    }
}
