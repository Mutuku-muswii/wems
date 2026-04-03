<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - WEMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            display: flex;
        }
        
        .login-left {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 60px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-left h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 20px; }
        .login-left p { font-size: 1.1rem; opacity: 0.9; line-height: 1.6; }
        
        .login-right {
            padding: 60px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-logo { text-align: center; margin-bottom: 40px; }
        .login-logo i { font-size: 4rem; color: #3498db; }
        .login-logo h3 { color: #2c3e50; margin-top: 15px; font-weight: 600; }
        
        .form-floating { margin-bottom: 20px; }
        .form-floating input { border-radius: 10px; border: 2px solid #e9ecef; }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 10px;
        }

        .features-list { list-style: none; padding: 0; margin-top: 30px; }
        .features-list li { padding: 10px 0; display: flex; align-items: center; gap: 10px; }
        .features-list i { color: #27ae60; font-size: 1.2rem; }

        @media (max-width: 768px) {
            .login-container { flex-direction: column; margin: 20px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <h1><i class="bi bi-calendar-event"></i> WEMS</h1>
            <p>Waridi Events Management System</p>
            <ul class="features-list">
                <li><i class="bi bi-check-circle-fill"></i> Track event budgets in real-time</li>
                <li><i class="bi bi-check-circle-fill"></i> Manage vendors and services</li>
                <li><i class="bi bi-check-circle-fill"></i> Client portal for transparency</li>
            </ul>
        </div>
        
        <div class="login-right">
            <div class="login-logo">
                <i class="bi bi-person-circle"></i>
                <h3>Welcome Back</h3>
                <p class="text-muted">Sign in to your account</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating">
                    <input type="email" class="form-control" name="email" placeholder="name@example.com" required autofocus>
                    <label><i class="bi bi-envelope me-2"></i>Email address</label>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    <label><i class="bi bi-lock me-2"></i>Password</label>
                </div>
                
                <button type="submit" class="btn btn-login">Sign In</button>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted mb-0">Don't have an account?</p>
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #667eea;">Create Account</a>
            </div>
        </div>
    </div>
</body>
</html>