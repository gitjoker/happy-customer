<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // สร้างตาราง stores ก่อน (เพราะ orders ต้องอ้างถึง store_id)
        Schema::create('stores', function (Blueprint $table) {
            $table->id(); // Primary Key (store_id)
            $table->string('name'); // ชื่อร้านค้า
            $table->timestamps(); // created_at, updated_at
        });

        // สร้างตาราง sellers ก่อน (เพราะ orders ต้องอ้างถึง seller_id)
        Schema::create('sellers', function (Blueprint $table) {
            $table->id(); // Primary Key (seller_id)
            $table->string('name'); // ชื่อผู้ขาย
            $table->timestamps(); // created_at, updated_at
        });

        // สร้างตาราง orders และเชื่อมกับ stores & sales
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary Key (order_id)
            $table->unsignedBigInteger('store_id'); // FK ไปยัง stores
            $table->unsignedBigInteger('seller_id'); // FK ไปยัง sellers
            $table->string('customer_name'); // ชื่อลูกค้า
            $table->string('customer_surname'); // นามสกุลลูกค้า
            $table->string('customer_phone'); // เบอร์โทรลูกค้า
            $table->string('customer_email')->nullable(); // อีเมลลูกค้า (เว้นว่างได้)
            $table->date('customer_birthdate')->nullable(); // วันเกิดลูกค้า (เว้นว่างได้)
            $table->decimal('total', 10, 2)->default(0); // ราคารวม
            $table->decimal('discount', 10, 2)->default(0); // ส่วนลด (ค่าเริ่มต้น = 0)
            $table->decimal('subtotal', 10, 2)->default(0); // ยอดรวมหลังหักส่วนลด
            $table->timestamps(); // created_at, updated_at

            // กำหนด Foreign Key เชื่อม store_id ไปยัง stores.id
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            // กำหนด Foreign Key เชื่อม seller_id ไปยัง sellers.id
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });

        // สร้างตาราง items และเชื่อมกับ orders
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // Primary Key (item_id)
            $table->unsignedBigInteger('order_id'); // FK ไปยัง orders
            $table->string('jewelry_type'); // ประเภทเครื่องประดับ
            $table->string('size'); // ขนาด
            $table->string('metal'); // ประเภทโลหะ
            $table->decimal('weight', 8, 2)->default(0); // น้ำหนัก
            $table->decimal('price', 10, 2)->default(0); // ราคาต่อชิ้น
            $table->integer('qty'); // จำนวน
            $table->decimal('total', 10, 2)->default(0); // ราคารวม (price * qty)
            $table->decimal('discount', 10, 2)->default(0); // ส่วนลด (ค่าเริ่มต้น = 0)
            $table->decimal('subtotal', 10, 2)->default(0); // ยอดรวมหลังหักส่วนลด
            $table->timestamps(); // created_at, updated_at

            // กำหนด Foreign Key เชื่อม order_id ไปยัง orders.id
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        // สร้างตาราง carats และเชื่อมกับ items
        Schema::create('carats', function (Blueprint $table) {
            $table->id(); // Primary Key (carat_id)
            $table->unsignedBigInteger('item_id'); // FK ไปยัง items
            $table->integer('carat_size'); // ขนาดกะรัต
            $table->string('shape'); // รูปทรงของเพชร
            $table->string('color'); // สีของเพชร
            $table->string('clarity'); // ระดับความใสของเพชร
            $table->boolean('has_certificate')->default(false); // มีใบรับรองหรือไม่ (ค่าเริ่มต้นเป็น false)
            $table->timestamps(); // created_at, updated_at

            // กำหนด Foreign Key
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ลบตาราง carats ก่อน (เพราะมี Foreign Key)
        Schema::dropIfExists('carats');
        // ลบตาราง items ก่อน orders
        Schema::dropIfExists('items');
        // ลบตาราง orders ก่อน stores & sales
        Schema::dropIfExists('orders');
        // ลบตาราง stores และ sales
        Schema::dropIfExists('stores');
        Schema::dropIfExists('sellers');
    }
};
