<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Store;
use App\Models\Seller;
use App\Models\Item;
use App\Models\Carat;

class OrderController extends Controller
{
    // public function create()
    // {
    //     $stores = Store::all();
    //     $sellers = Seller::all();

    //     return view('orders.create', compact('stores', 'sellers'));
    // }

    public function create()
    {
        // ดึงข้อมูล stores, sellers, และ orders ที่มีความสัมพันธ์ทั้งหมด
        $orders = Order::with(['store', 'seller', 'items.carats'])->latest()->get();

        return view('orders.create', [
            'stores' => Store::all(),
            'sellers' => Seller::all(),
            'orders' => $orders,
        ]);
    }


    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'seller_id' => 'required|exists:sellers,id',
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_birthdate' => 'nullable|date',
        ]);

        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'seller_id' => 'required|exists:sellers,id',
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_birthdate' => 'nullable|date',
            'items' => 'required|array',
            'items.*.jewelry_type' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.total' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
        ]);

        // คำนวณราคาสินค้าทั้งหมด
        $totalPrice = array_sum(array_column($request->items, 'total'));
        // คำนวณราคาส่วนลดทั้งหมด
        $discountPrice = array_sum(array_column($request->items, 'discount'));
        // คำนวณราคาสุทธิทั้งหมด
        $subtotalPrice = array_sum(array_column($request->items, 'subtotal'));

        // บันทึกข้อมูล Order
        $order = Order::create([
            'store_id' => $request->store_id,
            'seller_id' => $request->seller_id,
            'customer_name' => $request->customer_name,
            'customer_surname' => $request->customer_surname,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_birthdate' => $request->customer_birthdate,
            'total' => $totalPrice,
            'discount' => $discountPrice,
            'subtotal' => $subtotalPrice,
        ]);

        // บันทึกสินค้าทั้งหมด
        foreach ($request->items as $itemData) {
            $item = Item::create([
                'order_id' => $order->id,
                'jewelry_type' => $itemData['jewelry_type'],
                'size' => $itemData['size'] ?? null,
                'metal' => $itemData['metal'] ?? null,
                'weight' => $itemData['weight'] ?? null,
                'price' => $itemData['price'],
                'qty' => $itemData['qty'],
                'total' => $itemData['total'],
                'discount' => $itemData['discount'] ?? 0,
                'subtotal' => $itemData['subtotal'],
            ]);

            if (isset($itemData['carats'])) {
                foreach ($itemData['carats'] as $caratData) {
                    Carat::create([
                        'item_id' => $item->id,
                        'carat_size' => $caratData['carat_size'],
                        'shape' => $caratData['shape'],
                        'color' => $caratData['color'],
                        'clarity' => $caratData['clarity'],
                        'has_certificate' => isset($caratData['has_certificate']) ? 1 : 0,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'บันทึกคำสั่งซื้อเรียบร้อยแล้ว!');
    }
}
