<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Expense Tracker')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 15px;
        }
        
        .auth-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .auth-header h1 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.75rem;
        }
        
        .auth-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .brand-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            
            .auth-card {
                padding: 25px 20px;
                border-radius: 12px;
            }
            
            .auth-header h1 {
                font-size: 1.5rem;
            }
            
            .auth-header p {
                font-size: 0.875rem;
            }
            
            .brand-icon {
                font-size: 2.5rem;
            }
            
            .form-control {
                padding: 10px;
                font-size: 0.95rem;
            }
            
            .btn-primary {
                padding: 10px;
                font-size: 0.95rem;
            }
            
            .auth-footer {
                font-size: 0.85rem;
            }
            
            .form-label {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 375px) {
            .auth-card {
                padding: 20px 15px;
            }
            
            .auth-header h1 {
                font-size: 1.35rem;
            }
            
            .brand-icon {
                font-size: 2.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

