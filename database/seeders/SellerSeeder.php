<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('sellers')->insert([
            ['name' => 'James', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Powley', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mike', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kavin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Olivia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kate', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
