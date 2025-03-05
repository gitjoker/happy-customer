<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('stores')->insert([
            ['name' => 'Anatara Branch A', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anatara Branch B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Event A', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Event B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Online Website', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Line Application', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
