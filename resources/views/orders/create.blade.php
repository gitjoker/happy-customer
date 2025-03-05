<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างคำสั่งซื้อ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="d-flex justify-content-between align-items-center">
            สร้างคำสั่งซื้อ
            <a href="{{ url('/') }}" class="btn btn-primary">กลับไปหน้าแรก</a>
        </h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST">
            @csrf

            <!-- Group Store & Seller in One Row -->
            <div class="row">
                <!-- Store Select Box -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="store_id" class="form-label">เลือกร้านค้า</label>
                        <select name="store_id" class="form-select" required>
                            <option value="">-- กรุณาเลือกร้านค้า --</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Seller Select Box -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="seller_id" class="form-label">เลือกพนักงานขาย</label>
                        <select name="seller_id" class="form-select" required>
                            <option value="">-- กรุณาเลือกพนักงานขาย --</option>
                            @foreach($sellers as $seller)
                                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Customer Details -->
            <!-- Group Customer Name & Surname in One Row -->
            <div class="row">
                <!-- Customer Name -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">ชื่อลูกค้า</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                </div>

                <!-- Customer Surname -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="customer_surname" class="form-label">นามสกุลลูกค้า</label>
                        <input type="text" name="customer_surname" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Group Customer Phone, Email, and Birthdate in One Row -->
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">เบอร์โทร</label>
                        <input type="text" name="customer_phone" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">อีเมล (ถ้ามี)</label>
                        <input type="email" name="customer_email" class="form-control">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="customer_birthdate" class="form-label">วันเกิด (ถ้ามี)</label>
                        <input type="date" name="customer_birthdate" class="form-control">
                    </div>
                </div>
            </div>

            <h4>รายการสินค้า</h4>
            <button type="button" class="btn btn-success mb-3" id="addItem">+ เพิ่มสินค้า</button>

            <div id="itemsContainer">
                <!-- ช่องกรอกสินค้าจะถูกเพิ่มที่นี่ -->
            </div>

            <button type="submit" class="btn btn-primary">บันทึกคำสั่งซื้อ</button>
        </form>

        <h4 class="mt-5">รายการคำสั่งซื้อล่าสุด</h4>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>หมายเลขคำสั่งซื้อ</th>
                    <th>ร้านค้า</th>
                    <th>พนักงานขาย</th>
                    <th>ลูกค้า</th>
                    <th>สินค้า</th>
                    <th>ยอดรวม</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <!-- ข้อมูลคำสั่งซื้อ -->
                        <td rowspan="{{ $order->items->count() ?: 1 }}">{{ $order->id }}</td>
                        <td rowspan="{{ $order->items->count() ?: 1 }}">{{ $order->store->name }}</td>
                        <td rowspan="{{ $order->items->count() ?: 1 }}">{{ $order->seller->name }}</td>
                        <td rowspan="{{ $order->items->count() ?: 1 }}">
                            {{ $order->customer_name }} {{ $order->customer_surname }}<br>
                            <small>{{ $order->customer_phone }}</small>
                        </td>

                        <!-- แสดงรายการสินค้า -->
                        @if($order->items->count() > 0)
                            @foreach($order->items as $index => $item)
                                @if($index > 0)
                                    <tr>
                                @endif
                                <td>
                                    <strong>{{ $item->jewelry_type }}</strong> - ประเภทโลหะ : {{ $item->metal }} | ขนาด : {{ $item->size }} | น้ำหนัก : {{ $item->weight }} <br>
                                    ราคา: {{ number_format($item->price, 2) }} x {{ $item->qty }} ชิ้น <br>
                                    ส่วนลด: {{ number_format($item->discount, 2) }} <br>
                                    <strong>ยอดรวมสุทธิ: {{ number_format($item->subtotal, 2) }}</strong>

                                    @if($item->carats->count() > 0)
                                        <ul>
                                            @foreach($item->carats as $carat)
                                                <li>
                                                    เพชร {{ $carat->carat_size }} กะรัต | 
                                                    รูปทรง: {{ $carat->shape }} | 
                                                    สี: {{ $carat->color }} | 
                                                    ความใส: {{ $carat->clarity }} | 
                                                    ใบรับรอง: {{ $carat->has_certificate ? 'มี' : 'ไม่มี' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>

                                <!-- รวมราคาสุดท้าย (แสดงแค่แถวแรกของ Order) -->
                                @if($index == 0)
                                    <td rowspan="{{ $order->items->count() ?: 1 }}">
                                        <strong>{{ number_format($order->subtotal, 2) }}</strong>
                                    </td>
                                @endif

                                @if($index > 0)
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <!-- กรณีไม่มีสินค้า -->
                            <td>ไม่มีสินค้า</td>
                            <td>
                                <strong>{{ number_format($order->subtotal, 2) }}</strong>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .readonly-field {
            background-color: #e9ecef !important; /* สีเทาอ่อน */
            cursor: not-allowed;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#addItem").click(function(){
                let itemIndex = $(".item-row").length; // นับจำนวนรายการสินค้า
                let newItem = `
                    <div class="item-row border p-3 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">ประเภทเครื่องประดับ</label>
                                <select name="items[${itemIndex}][jewelry_type]" class="form-select" required>
                                    <option value="">-- กรุณาเลือกประเภท --</option>
                                    <option value="Ring">Ring</option>
                                    <option value="Necklace">Necklace</option>
                                    <option value="Bracelet">Bracelet</option>
                                    <option value="Earrings">Earrings</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ขนาด</label>
                                <input type="text" name="items[${itemIndex}][size]" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ประเภทโลหะ</label>
                                <input type="text" name="items[${itemIndex}][metal]" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-2">
                                <label class="form-label">น้ำหนัก</label>
                                <input type="number" step="0.01" name="items[${itemIndex}][weight]" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">ราคาต่อชิ้น</label>
                                <input type="number" step="0.01" name="items[${itemIndex}][price]" class="form-control price" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">จำนวน</label>
                                <input type="number" name="items[${itemIndex}][qty]" class="form-control qty" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">ยอดรวม</label>
                                <input type="text" name="items[${itemIndex}][total]" class="form-control total readonly-field" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">ส่วนลด</label>
                                <input type="number" step="0.01" name="items[${itemIndex}][discount]" class="form-control discount">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">ยอดรวมสุทธิ</label>
                                <input type="text" name="items[${itemIndex}][subtotal]" class="form-control subtotal readonly-field" readonly>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary addCarat mt-2">+ เพิ่มเพชร</button>
                        <div class="caratsContainer"></div>
                        <button type="button" class="btn btn-danger mt-2 remove-item">ลบ</button>
                    </div>
                `;
                $("#itemsContainer").append(newItem);
            });

            $(document).on("click", ".addCarat", function(){
                let itemRow = $(this).closest(".item-row");
                let itemIndex = $(".item-row").index(itemRow);
                let caratIndex = itemRow.find(".carat-row").length;
                let newCarat = `
                    <div class="carat-row mt-2 p-2 border">
                        <h6>เพชร #${caratIndex + 1}</h6>
                        <div class="row">
                            <div class="col-md-2">
                                <label>ขนาดกะรัต</label>
                                <input type="number" name="items[${itemIndex}][carats][${caratIndex}][carat_size]" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>รูปทรง</label>
                                <select name="items[${itemIndex}][carats][${caratIndex}][shape]" class="form-select">
                                    <option value="Round">Round</option>
                                    <option value="Princess">Princess</option>
                                    <option value="Emerald">Emerald</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>สี</label>
                                <select name="items[${itemIndex}][carats][${caratIndex}][color]" class="form-select">
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>ความใส</label>
                                <select name="items[${itemIndex}][carats][${caratIndex}][clarity]" class="form-select">
                                    <option value="FL">FL</option>
                                    <option value="IF">IF</option>
                                    <option value="VVS1">VVS1</option>
                                    <option value="VVS2">VVS2</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>ใบรับรอง</label>
                                <select name="items[${itemIndex}][carats][${caratIndex}][has_certificate]" class="form-select">
                                    <option value="0">ไม่มี</option>
                                    <option value="1">มี</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-carat mt-4">ลบเพชร</button>
                            </div>
                        </div>
                    </div>
                `;
                itemRow.find(".caratsContainer").append(newCarat);
            });

            // ลบรายการเพชร
            $(document).on("click", ".remove-carat", function(){
                $(this).closest(".carat-row").remove();
            });

            // ลบรายการสินค้า
            $(document).on("click", ".remove-item", function(){
                $(this).closest(".item-row").remove();
            });

            // คำนวณค่า total & subtotal
            $(document).on("input", ".price, .qty, .discount", function(){
                let row = $(this).closest(".item-row");
                let price = parseFloat(row.find(".price").val()) || 0;
                let qty = parseInt(row.find(".qty").val()) || 0;
                let discount = parseFloat(row.find(".discount").val()) || 0;
                
                let total = price * qty;
                let subtotal = total - discount;
                
                row.find(".total").val(total.toFixed(2)); // อัปเดตยอดรวม
                row.find(".subtotal").val(subtotal.toFixed(2)); // อัปเดตยอดรวมสุทธิ
            });
            
        });
    </script>
</body>
</html>
