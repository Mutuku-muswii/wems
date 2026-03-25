<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Waridi Events Management System - Final Year Project">
    <meta name="author" content="Muswii Collins Mutuku">
    <title>WEMS - Login</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
            min-height: 100vh;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-login {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .card-login .card-body {
            padding: 2rem;
        }
        
        .login-icon {
            font-size: 3rem;
            color: #4e73df;
        }
        
        .form-control-user {
            font-size: 0.8rem;
            border-radius: 10rem;
            padding: 1rem 1.5rem;
        }
        
        .btn-user {
            font-size: 0.8rem;
            border-radius: 10rem;
            padding: 0.75rem 1rem;
        }
        
        .project-info {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .project-info h4 {
            color: #5a5c69;
            font-weight: 700;
        }
        
        .project-info p {
            color: #858796;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card card-login o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect fill=%22%23f8f9fc%22 width=%22100%22 height=%22100%22/><text x=%2250%22 y=%2250%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%234e73df%22 text-anchor=%22middle%22 dy=%22.3em%22>WEMS</text></svg>'); background-position: center; background-size: cover;"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center project-info">
                                            <i class="bi bi-calendar-event login-icon mb-3"></i>
                                            <h4 class="mb-2">WEMS</h4>
                                            <p>Waridi Events Management System</p>
                                            <hr>
                                            <p class="small"><strong>Final Year Project</strong><br>BBIT 04205 | Reg: 22/05989</p>
                                        </div>
                                        
                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                {{ $errors->first() }}
                                            </div>
                                        @endif
                                        
                                        <form class="user" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <input type="email" class="form-control form-control-user" 
                                                       name="email" placeholder="Enter Email Address..." required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="password" class="form-control form-control-user" 
                                                       name="password" placeholder="Password" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user w-100">
                                                Login
                                            </button>
                                        </form>
                                        
                                        <hr>
                                        <div class="text-center">
                                            <small class="text-muted">
                                                <strong>Demo Accounts:</strong><br>
                                                admin@waridi.com / password<br>
                                                manager@waridi.com / password<br>
                                                client@example.com / password
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>