<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANANTA Technical Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; text-align: center; }
        .container { width: 80%; max-width: 900px; margin: 50px auto; }
        h1 { color: #333; }
        .row { display: flex; padding: 10px; border-bottom: 1px solid #ddd; align-items: center; }
        .row div { padding: 10px; }
        .col-1 { width: 10%; font-weight: bold; }
        .col-2 { width: 50%; text-align: left; }
        .col-3 { width: 40%; text-align: left; color: #666; }
        a { text-decoration: none; color: #007bff; font-size: 18px; }
        a:hover { text-decoration: underline; }
        img { max-width: 100%; height: auto; border: 1px solid #ccc; padding: 5px; border-radius: 5px; cursor: pointer; }

        /* CSS สำหรับ Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            max-width: 80%;
            max-height: 80%;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 25px;
            color: white;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>ส่งคำตอบ ANANTA Technical Test</h1>
        <p>คำตอบจะเรียงตามคำถามในเอกสาร:</p>

        <div class="row">
            <div class="col-1">1</div>
            <div class="col-2"><a href="{{ url('/create-order') }}">🔗 Happy Customer</a></div>
            <div class="col-3">โปรแกรมสำหรับบันทึกคำสั่งซื้อของลูกค้าที่ขายสำหรับช่องทางต่างๆ</div>
        </div>

        <div class="row">
            <div class="col-1">2</div>
            <div class="col-2">
                <img id="myImg" src="{{ asset('images/HappyCustomer-Db.png') }}" alt="รูปตัวอย่าง">
            </div>
            <div class="col-3">ภาพ ER Diagram Database ของ Happy Customer Application</div>
        </div>

        <div class="row">
            <div class="col-1">3</div>
            <div class="col-2"><a href="{{ url('/query-1') }}">🔗 ตัวอย่าง SQL</a></div>
            <div class="col-3">SQL Query ยอดขายรายเดือนของแต่ละสาขา ตามประเภทของสินค้า และพนักงานขาย</div>
        </div>

        <div class="row">
            <div class="col-1">4</div>
            <div class="col-2"><a href="{{ url('/query-2') }}">🔗 ตัวอย่าง SQL</a></div>
            <div class="col-3">SQL Query ยอดขายต่อใบเสร็จแยกตามช่วงอายุของลูกค้า</div>
        </div>

        <div class="row">
            <div class="col-1">5</div>
            <div class="col-2">
                <b>{{ url('/api/orders') }}</b>
            </div>
            <div class="col-3">API ใช้สำหรับรับข้อมูลออเดอร์จาก POS ด้วย Method POST</div>
        </div>

        <div class="row">
            <div class="col-1">6</div>
            <div class="col-2"><a href="{{ url('/code-sample') }}">🔗 ตัวอย่าง Code</a></div>
            <div class="col-3">ตัวอย่าง code API ไว้ด้วยสำหรับการดึงข้อมูลแบบ Batch จากระบบ POS รายวัน</div>
        </div>

        <div class="row">
            <div class="col-1">7</div>
            <div class="col-2"><a href="{{ url('/rhyme-scheme-validate') }}">🔗 Rhyme Scheme Validate</a></div>
            <div class="col-3">โปรแกรมสำหรับตรวจสอบ Rhyme Scheme</div>
        </div>

    </div>

    <!-- Modal สำหรับแสดงภาพขนาดใหญ่ -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
    </div>

    <script>
        // JavaScript สำหรับเปิดและปิด Modal
        var modal = document.getElementById("myModal");
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var closeBtn = document.getElementsByClassName("close")[0];

        // เปิด Modal เมื่อคลิกที่ภาพ
        img.onclick = function() {
            modal.style.display = "flex";
            modalImg.src = this.src;
        }

        // ปิด Modal เมื่อคลิกปุ่ม X
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // ปิด Modal เมื่อคลิกที่พื้นที่มืดด้านนอก
        modal.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        // ปิด Modal เมื่อกดปุ่ม ESC
        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape" && modal.style.display === "flex") {
                modal.style.display = "none";
            }
        });
    </script>

</body>
</html>
