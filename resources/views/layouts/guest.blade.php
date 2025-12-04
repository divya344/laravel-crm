<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GrowCRM')</title>

    <!-- Bootstrap + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6, #93c5fd);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            padding: 40px 35px;
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        .auth-card img {
            height: 90px;
            margin-bottom: 10px;
        }

        h2 {
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #d1d5db;
            transition: 0.2s ease;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .btn-primary {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s ease;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #1e40af, #2563eb);
            transform: translateY(-2px);
        }

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #374151;
        }

        .footer-text a {
            color: #1e40af;
            font-weight: 500;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="auth-card">
        <img src="{{ asset('images/login-1.png') }}" alt="GrowCRM Logo">
        @yield('content')
        <p class="footer-text">@yield('footer')</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
