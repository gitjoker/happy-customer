<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบรูปแบบสัมผัส</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center vh-100 bg-light">

    <div class="container">
        <!-- ปุ่มกลับไปหน้าแรก -->
        <div class="d-flex justify-content-center mt-5 mb-3"> <!-- เพิ่ม mt-5 -->
            <a href="{{ url('/') }}" class="btn btn-primary">กลับไปหน้าแรก</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-4">ตรวจสอบรูปแบบสัมผัส</h2>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('rhyme_scheme') }}
                        </div>
                    @endif

                    <form method="post" action="/rhyme-scheme-validate">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="rhyme_scheme" value="{{ old('rhyme_scheme') }}" class="form-control" placeholder="กรอกโครงสร้างสัมผัส เช่น ABBA CDCD" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">ตรวจสอบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
