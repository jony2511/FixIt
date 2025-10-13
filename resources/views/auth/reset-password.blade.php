<x-guest-layout>
    <!-- Left Section - Illustration -->
    <div class="left-section bg-gradient-to-r from-emerald-100 to-indigo-600">
        <!-- Company Logo -->
        <a href="{{ route('home') }}" class="company-logo hover:opacity-80 transition-opacity duration-200">
            <div class="logo-icon">
                <!-- FixIt Icon -->
                <img src="{{ asset('images/image1.png') }}" alt="FixIt Solutions" width="32" height="32" class="object-contain">
            </div>
            FixIt Solutions
        </a>
        
        <!-- Illustration Container -->
        <div class="illustration-container">
            <!-- Animated Image Scene -->
            <div class="image-scene">
                <!-- Main Image -->
                <div class="main-image">
                    <img src="{{ asset('images/image2.png') }}" alt="FixIt Workspace" class="workspace-image">
                </div>
                
                <!-- Floating Animation Elements -->
                <div class="floating-elements">
                    <div class="float-icon gear">⚙️</div>
                    <div class="float-icon tools">🔧</div>
                    <div class="float-icon phone">📱</div>
                    <div class="float-icon rocket">🚀</div>
                    <div class="float-icon star">⭐</div>
                    <div class="float-icon bolt">⚡</div>
                </div>
                
                <!-- Animated Background Elements -->
                <div class="bg-elements">
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>
                    <div class="circle circle-3"></div>
                </div>
            </div>
        </div>

        <style>
            .image-scene {
                position: relative;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                margin: 20px;
            }

            .main-image {
                position: relative;
                z-index: 20;
                animation: imageFloat 6s ease-in-out infinite;
            }

            .workspace-image {
                max-width: 350px;
                max-height: 350px;
                width: 100%;
                height: auto;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .workspace-image:hover {
                transform: scale(1.05);
            }

            /* Floating Elements */
            .floating-elements {
                position: absolute;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 15;
            }

            .float-icon {
                position: absolute;
                font-size: 28px;
                opacity: 0.8;
                animation: floatAround 8s ease-in-out infinite;
                text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            }

            .gear {
                top: 15%;
                left: 85%;
                animation-delay: 0s;
                animation-duration: 10s;
            }

            .tools {
                top: 65%;
                right: 10%;
                animation-delay: 2s;
                animation-duration: 9s;
            }

            .phone {
                top: 25%;
                left: 10%;
                animation-delay: 4s;
                animation-duration: 8s;
            }

            .rocket {
                top: 80%;
                left: 80%;
                animation-delay: 1s;
                animation-duration: 11s;
            }

            .star {
                top: 40%;
                left: 5%;
                animation-delay: 3s;
                animation-duration: 7s;
                font-size: 22px;
            }

            .bolt {
                top: 70%;
                right: 85%;
                animation-delay: 5s;
                animation-duration: 9s;
                font-size: 24px;
            }

            /* Background Animated Circles */
            .bg-elements {
                position: absolute;
                width: 100%;
                height: 100%;
                z-index: 5;
            }

            .circle {
                position: absolute;
                border-radius: 50%;
                opacity: 0.2;
                animation: circleFloat 12s ease-in-out infinite;
            }

            .circle-1 {
                width: 100px;
                height: 100px;
                background: linear-gradient(45deg, rgba(249, 115, 22, 0.3), rgba(251, 146, 60, 0.3));
                top: 20%;
                left: 15%;
                animation-delay: 0s;
            }

            .circle-2 {
                width: 150px;
                height: 150px;
                background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(99, 102, 241, 0.3));
                bottom: 25%;
                right: 20%;
                animation-delay: 4s;
            }

            .circle-3 {
                width: 80px;
                height: 80px;
                background: linear-gradient(45deg, rgba(16, 185, 129, 0.3), rgba(5, 150, 105, 0.3));
                top: 60%;
                left: 70%;
                animation-delay: 8s;
            }

            /* Animations */
            @keyframes imageFloat {
                0%, 100% { 
                    transform: translateY(0px) rotate(0deg); 
                }
                33% { 
                    transform: translateY(-10px) rotate(1deg); 
                }
                66% { 
                    transform: translateY(5px) rotate(-1deg); 
                }
            }

            @keyframes floatAround {
                0%, 100% { 
                    transform: translateY(0px) rotate(0deg) scale(1); 
                    opacity: 0.8; 
                }
                25% { 
                    transform: translateY(-15px) rotate(90deg) scale(1.1); 
                    opacity: 1; 
                }
                50% { 
                    transform: translateY(-5px) rotate(180deg) scale(0.9); 
                    opacity: 0.7; 
                }
                75% { 
                    transform: translateY(-20px) rotate(270deg) scale(1.2); 
                    opacity: 0.9; 
                }
            }

            @keyframes circleFloat {
                0%, 100% { 
                    transform: translateY(0px) scale(1); 
                    opacity: 0.2; 
                }
                50% { 
                    transform: translateY(-30px) scale(1.2); 
                    opacity: 0.3; 
                }
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .workspace-image {
                    max-width: 280px;
                    max-height: 280px;
                }
                
                .float-icon {
                    font-size: 22px;
                }
                
                .circle {
                    transform: scale(0.7);
                }
            }

            @media (max-width: 480px) {
                .workspace-image {
                    max-width: 240px;
                    max-height: 240px;
                }
                
                .float-icon {
                    font-size: 18px;
                }
            }
        </style>
    </div>
    
    <!-- Right Section - Reset Password Form -->
    <div class="right-section">
        <div class="login-form-container">
            <!-- Title and Subtitle -->
            <div class="login-title">Reset Password</div>
            <div class="login-subtitle">Create New Password</div>
            <div class="login-description">Enter your new secure password</div>
            
            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        id="email" 
                        class="form-input" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}" 
                        placeholder="Your email"
                        required 
                        autofocus 
                        autocomplete="username"
                        readonly
                    />
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- New Password -->
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input 
                        id="password" 
                        class="form-input"
                        type="password"
                        name="password"
                        placeholder="Create new password"
                        required 
                        autocomplete="new-password"
                    />
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        id="password_confirmation" 
                        class="form-input"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        required 
                        autocomplete="new-password"
                    />
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Reset Password Button -->
                <button type="submit" class="login-button">
                    Update Password
                </button>
                
                <!-- Bottom Links -->
                <div class="bottom-link">
                    Remember your password? 
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
