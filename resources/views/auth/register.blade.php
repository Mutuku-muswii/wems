<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - WEMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        /* Reusing your Login Styles for Consistency */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px;
            margin-bottom: 15px;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color: #2c3e50;">Create Account</h3>
            <p class="text-muted">Join Waridi Events Management System</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            
            <label class="small fw-bold text-muted mb-1 ms-1">I am a:</label>
            <select name="role" class="form-select" required>
                <option value="client">Client (Event Host)</option>
                <option value="vendor">Vendor (Service Provider)</option>
            </select>

            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>

            <button type="submit" class="btn btn-register">Register</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none small" style="color: #667eea;">Already have an account? Login</a>
        </div>
    </div>
</body>
</html>