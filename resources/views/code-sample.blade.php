<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Sample</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; text-align: center; }
        .container { width: 80%; max-width: 900px; margin: 50px auto; text-align: left; }
        h1 { color: #333; text-align: center; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; white-space: pre-wrap; word-wrap: break-word; text-align: left; border: 1px solid #ccc; font-size: 14px; }
        code { font-family: monospace; font-size: 14px; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <h1 class="d-flex justify-content-between align-items-center">
            Code Sample
            <a href="{{ url('/') }}" class="btn btn-primary">กลับไปหน้าแรก</a>
        </h1>
        
        <pre><code>{{ $codeContent }}</code></pre>
    </div>

</body>
</html>
