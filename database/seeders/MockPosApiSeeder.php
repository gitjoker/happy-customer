<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MockPosApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sellers')->insert([
            ['id' => 465, 'name' => 'POS-seller01', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('stores')->insert([
            ['id' => 134, 'name' => 'Pos-Branch A', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
