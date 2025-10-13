<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FixIt') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            
            .login-container {
                min-height: 100vh;
                display: flex;
            }
            
            .left-section {
                flex: 1;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                position: relative;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px;
            }
            
            .right-section {
                flex: 1;
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px;
                position: relative;
            }
            
            .illustration-container {
                position: relative;
                width: 100%;
                max-width: 500px;
                height: 400px;
            }
            
            .company-logo {
                position: absolute;
                top: 30px;
                left: 30px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 600;
                color: #374151;
                font-size: 18px;
            }
            
            .logo-icon {
                width: 24px;
                height: 24px;
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .login-form-container {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(20px);
                border-radius: 20px;
                padding: 40px;
                width: 100%;
                max-width: 400px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .login-title {
                color: white;
                font-size: 32px;
                font-weight: 700;
                margin-bottom: 8px;
                text-align: center;
            }
            
            .login-subtitle {
                color: rgba(255, 255, 255, 0.8);
                font-size: 18px;
                font-weight: 500;
                margin-bottom: 12px;
                text-align: center;
            }
            
            .login-description {
                color: rgba(255, 255, 255, 0.7);
                font-size: 14px;
                margin-bottom: 32px;
                text-align: center;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-label {
                color: rgba(255, 255, 255, 0.9);
                font-size: 14px;
                font-weight: 500;
                margin-bottom: 8px;
                display: block;
            }
            
            .form-input {
                width: 100%;
                padding: 14px 16px;
                border: 2px solid rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.1);
                color: white;
                font-size: 16px;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }
            
            .form-input:focus {
                outline: none;
                border-color: #fbbf24;
                background: rgba(255, 255, 255, 0.15);
                box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
            }
            
            .form-input::placeholder {
                color: rgba(255, 255, 255, 0.5);
            }
            
            .login-button {
                width: 100%;
                padding: 14px;
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                border: none;
                border-radius: 12px;
                color: white;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 12px;
            }
            
            .login-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
            }
            
            .bottom-link {
                text-align: center;
                margin-top: 24px;
                color: rgba(255, 255, 255, 0.7);
                font-size: 14px;
            }
            
            .bottom-link a {
                color: #fbbf24;
                text-decoration: underline;
                font-weight: 500;
            }
            
            .error-message {
                color: #fecaca;
                font-size: 12px;
                margin-top: 6px;
                font-weight: 500;
            }
            
            .success-message {
                background: rgba(34, 197, 94, 0.1);
                border: 1px solid rgba(34, 197, 94, 0.2);
                color: #bbf7d0;
                padding: 12px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 14px;
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .login-container {
                    flex-direction: column;
                }
                
                .left-section {
                    height: 40vh;
                    padding: 20px;
                }
                
                .right-section {
                    height: 60vh;
                    padding: 20px;
                }
                
                .company-logo {
                    position: relative;
                    top: 0;
                    left: 0;
                    justify-content: center;
                    margin-bottom: 20px;
                }
                
                .illustration-container {
                    height: 200px;
                }
                
                .login-form-container {
                    padding: 30px 20px;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="login-container">
            {{ $slot }}
        </div>
    </body>
</html>
