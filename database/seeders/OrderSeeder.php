<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // ดึง store และ seller ที่มีอยู่ (หรือสร้างถ้ายังไม่มี)
        // $store = DB::table('stores')->first() ?? DB::table('stores')->insertGetId(['name' => 'Store A', 'created_at' => now(), 'updated_at' => now()]);
        // $seller = DB::table('sellers')->first() ?? DB::table('sellers')->insertGetId(['name' => 'Seller A', 'created_at' => now(), 'updated_at' => now()]);

        for ($i = 0; $i < 10; $i++) {
            // สุ่มค่า store_id และ seller_id ระหว่าง 1-6
            $store = rand(1, 6);
            $seller = rand(1, 6);

            // สร้าง Order ใหม่
            $orderId = DB::table('orders')->insertGetId([
                'store_id' => $store,
                'seller_id' => $seller,
                'customer_name' => $faker->firstName,
                'customer_surname' => $faker->lastName,
                'customer_phone' => $faker->phoneNumber,
                'customer_email' => $faker->optional()->email,
                'customer_birthdate' => $faker->optional()->date,
                'total' => 0,
                'discount' => 0,
                'subtotal' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $totalOrder = 0;
            $subtotalOrder = 0;

            for ($j = 0; $j < 2; $j++) {
                // สร้าง Item สำหรับ Order นี้
                $price = $faker->randomFloat(2, 1000, 10000);
                $qty = $faker->numberBetween(1, 5);
                $discount = $faker->randomFloat(2, 0, 200);
                $subtotal = ($price * $qty) - $discount;
                
                $itemId = DB::table('items')->insertGetId([
                    'order_id' => $orderId,
                    'jewelry_type' => $faker->randomElement(['Ring', 'Necklace', 'Bracelet', 'Earrings']),
                    'size' => $faker->randomElement(['Small', 'Medium', 'Large']),
                    'metal' => $faker->randomElement(['Gold', 'Silver', 'Platinum']),
                    'weight' => $faker->randomFloat(2, 1, 10),
                    'price' => $price,
                    'qty' => $qty,
                    'total' => $price * $qty,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalOrder += $price * $qty;
                $subtotalOrder += $subtotal;

                // สร้าง Carat สำหรับ Item นี้
                DB::table('carats')->insert([
                    'item_id' => $itemId,
                    'carat_size' => $faker->numberBetween(1, 5),
                    'shape' => $faker->randomElement(['Round', 'Princess', 'Emerald']),
                    'color' => $faker->randomElement(['D', 'E', 'F', 'G', 'H']),
                    'clarity' => $faker->randomElement(['FL', 'IF', 'VVS1', 'VVS2']),
                    'has_certificate' => $faker->boolean,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // อัปเดต total และ subtotal ของ Order
            DB::table('orders')->where('id', $orderId)->update([
                'total' => $totalOrder,
                'subtotal' => $subtotalOrder,
                'updated_at' => now(),
            ]);
        }
    }
}
