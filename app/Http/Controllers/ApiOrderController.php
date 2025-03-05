<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class ApiOrderController extends Controller
{
    /**
     * รับข้อมูล Order ผ่าน API
     */
    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่รับมา
        $validator = Validator::make($request->all(), [
            'orderId' => 'required|string|max:255',
            'timestamp' => 'required|date_format:Y-m-d H:i:s',
            'deviceId' => 'required|string|max:255',
            'salesPerson' => 'required|integer|exists:sellers,id',
            'posPerson' => 'required|integer',
            'products' => 'required|array|min:1',
            'products.*.code' => 'required|string|max:255',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.unitPrice' => 'required|numeric|min:0',
            'products.*.discountCode' => 'nullable|string|max:255',
            'products.*.discount' => 'required|numeric|min:0',
            'products.*.subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // บันทึก Order
        $order = Order::create([
            'store_id' => $request->posPerson, // ค่าคงที่ หรือสามารถส่งมาจาก Request
            'seller_id' => $request->salesPerson,
            'customer_name' => 'N/A',
            'customer_surname' => 'N/A',
            'customer_phone' => 'N/A',
            'customer_email' => null,
            'customer_birthdate' => null,
            'total' => $request->total,
            'discount' => $request->discount,
            'subtotal' => $request->total - $request->discount,
        ]);

        // บันทึก Items
        foreach ($request->products as $product) {
            Item::create([
                'order_id' => $order->id,
                'jewelry_type' => 'Unknown', // ต้องเปลี่ยนเป็นค่าจริงหากต้องการ
                'size' => 'N/A',
                'metal' => 'N/A',
                'weight' => 0,
                'price' => $product['unitPrice'],
                'qty' => $product['qty'],
                'total' => $product['unitPrice'] * $product['qty'],
                'discount' => $product['discount'],
                'subtotal' => $product['subtotal'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order has been successfully recorded',
            'order_id' => $order->id
        ], 201);
    }
}
