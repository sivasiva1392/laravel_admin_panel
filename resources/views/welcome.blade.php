<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Shop Admin Panel</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            height: 100vh;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        
        .container-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
            max-width: 1200px;
            width: 40vw;
            height: 50vh;
            max-height: 800px;
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
            display: flex;
            flex-direction: column;
        }
        
        .welcome-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 40px 30px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            position: relative;
            z-index: 10;
        }
        
        .logout-form {
            display: inline;
            position: relative;
            z-index: 10;
        }
        
        .welcome-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .logo-section {
            margin-bottom: 30px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            color: #667eea;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            animation: float 3s ease-in-out infinite;
        }
        
        .welcome-title {
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .welcome-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 40px;
        }
        
        .welcome-body {
            flex: 1;
            padding: 0;
            overflow-y: auto;
            max-height: calc(90vh - 200px);
            margin-bottom: 20px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            max-height: calc(90vh - 200px);
            overflow-y: auto;
            padding: 10px;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: white;
        }
        
        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .feature-description {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            font-family: 'Inter', sans-serif;
            position: relative;
            z-index: 10;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .logout-form {
            display: inline;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container-wrapper {
                padding: 5px;
            }
            
            .welcome-card {
                margin: 5px;
                border-radius: 15px;
                width: 95vw;
                height: 85vh;
                max-height: none;
            }
            
            .welcome-header {
                padding: 20px 15px;
            }
            
            .welcome-title {
                font-size: 20px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 10px;
                max-height: none;
                padding: 5px;
            }
            
            .feature-card {
                padding: 15px;
            }
            
            .auth-buttons {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .welcome-title {
                font-size: 18px;
            }
            
            .feature-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
            
            .feature-card {
                padding: 15px 10px;
            }
            
            .features-grid {
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <div class="welcome-card">
            <div class="welcome-header">
                <div class="logo-section">
                    <div class="logo">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                
                @if (Route::has('login'))
                    <div class="auth-buttons">
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i>
                                Login
                            </a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-secondary">
                                    <i class="fas fa-user-plus"></i>
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <h1 class="welcome-title">E-Shop Admin Panel</h1>
                <p class="welcome-subtitle">Complete E-Commerce Management Solution</p>
               
            </div>
        </div>
    </div>
</body>
<script>
    // Test button clicks
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Welcome page loaded - Testing buttons...');
        
        // Test all buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach((button, index) => {
            console.log(`Button ${index + 1}:`, button);
            button.addEventListener('click', function(e) {
                console.log('Button clicked:', this.textContent.trim());
            });
        });
        
        // Test logout form
        const logoutForm = document.querySelector('.logout-form');
        if (logoutForm) {
            console.log('Logout form found');
            logoutForm.addEventListener('submit', function(e) {
                console.log('Logout form submitted');
            });
        }
    });
</script>
</html>
