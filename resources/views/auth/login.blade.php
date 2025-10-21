<x-guest-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 bg-clip-text text-transparent mb-8 animate-gradient text-center animate-fadeInDown whitespace-nowrap inline-block px-4 py-2"
        style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif; font-kerning: none; letter-spacing: -0.02em; line-height: 1.1; text-transform: uppercase;">
        ĐĂNG NHẬP
    </h2>

    <x-auth-session-status class="mb-4 animate-fadeIn" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div class="group animate-slideInLeft">
            <label for="email" class="block font-semibold text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                Email
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-blue-500 group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required autofocus
                       autocomplete="username"
                       class="block w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-white to-gray-50 text-gray-900 border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md placeholder:text-gray-400"
                       placeholder="Nhập địa chỉ email của bạn"
                       style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2 animate-shake" />
            </div>
        </div>

        <!-- Password -->
        <div class="group animate-slideInLeft delay-100">
            <label for="password" class="block font-semibold text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                Mật khẩu
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-blue-500 group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                
                <input id="password"
                       type="password"
                       name="password"
                       required autocomplete="current-password"
                       class="block w-full pl-12 pr-12 py-3.5 bg-gradient-to-br from-white to-gray-50 text-gray-900 border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md placeholder:text-gray-400"
                       placeholder="Nhập mật khẩu của bạn"
                       style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;"
                />

                <!-- Toggle Password Visibility -->
                <button type="button" 
                        onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-500 transition-all duration-300 focus:outline-none group/eye">
                    <svg id="eye-open" class="w-5 h-5 transition-all duration-300 group-hover/eye:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eye-closed" class="w-5 h-5 hidden transition-all duration-300 group-hover/eye:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>

                <x-input-error :messages="$errors->get('password')" class="mt-2 animate-shake" />
            </div>
        </div>

        <!-- Remember Me + Quên mật khẩu -->
        <div class="flex items-center justify-between mt-6 animate-fadeInUp">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group/check"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded-md border-2 border-gray-400 text-blue-600 shadow-sm focus:ring-4 focus:ring-blue-500/30 transition-all duration-200 hover:border-blue-500 hover:scale-110 cursor-pointer">
                <span class="ml-2 text-sm text-gray-600 transition-all duration-200 group-hover/check:text-gray-900 group-hover/check:translate-x-0.5">
                    Ghi nhớ đăng nhập
                </span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-blue-600 hover:text-blue-800 transition-all duration-300 hover:underline decoration-2 underline-offset-4 hover:underline-offset-2 hover:scale-105 inline-block relative group/forgot"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                    <span class="relative">
                        Quên mật khẩu?
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover/forgot:w-full"></span>
                    </span>
                </a>
            @endif
        </div>

        <!-- Button Đăng nhập -->
        <div class="flex items-center justify-end mt-6 animate-slideInRight">
            <button type="submit"
                    class="w-full relative overflow-hidden px-6 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 bg-[length:200%_100%] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wide shadow-lg shadow-blue-500/40 transition-all duration-500 hover:bg-[position:100%_0] hover:shadow-2xl hover:shadow-blue-600/50 hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-500/50 active:scale-95 group/btn"
                    style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                <span class="relative z-10 flex items-center justify-center">
                    Đăng nhập
                    <svg class="ml-2 w-4 h-4 transition-all duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </span>
                
                <!-- Shimmer Effect -->
                <span class="absolute inset-0 w-full h-full">
                    <span class="absolute inset-0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/30 to-transparent"></span>
                </span>
                
                <!-- Ripple Effect on Click -->
                <span class="absolute inset-0 rounded-xl overflow-hidden">
                    <span class="ripple"></span>
                </span>

                <!-- Particles on Hover -->
                <span class="particle particle-1"></span>
                <span class="particle particle-2"></span>
                <span class="particle particle-3"></span>
            </button>
        </div>
    </form>

    <style>
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes gradient {
            0%, 100% {
                background-size: 200% 200%;
                background-position: left center;
            }
            50% {
                background-size: 200% 200%;
                background-position: right center;
            }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(4);
                opacity: 0;
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes particle {
            0% {
                transform: translate(0, 0) scale(0);
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(1);
                opacity: 0;
            }
        }
        
        .animate-gradient {
            animation: gradient 3s ease infinite;
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-fadeInDown {
            animation: fadeInDown 0.8s ease-out;
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }
        
        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out 0.2s both;
        }

        .delay-100 {
            animation-delay: 0.3s !important;
        }
        
        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out 0.5s both;
        }
        
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Ripple effect */
        button:active .ripple {
            animation: ripple 0.6s ease-out;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        /* Input focus glow */
        input:focus {
            animation: glow 1.5s ease-in-out infinite;
        }
        
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 5px rgba(59, 130, 246, 0.2), 0 0 10px rgba(59, 130, 246, 0.1);
            }
            50% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3), 0 0 30px rgba(59, 130, 246, 0.2);
            }
        }
        
        /* Particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
        }

        button:hover .particle-1 {
            animation: particle 1s ease-out infinite;
            --tx: -30px;
            --ty: -30px;
        }

        button:hover .particle-2 {
            animation: particle 1s ease-out 0.2s infinite;
            --tx: 30px;
            --ty: -30px;
        }

        button:hover .particle-3 {
            animation: particle 1s ease-out 0.4s infinite;
            --tx: 0px;
            --ty: -40px;
        }
        
        /* Smooth transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Loading state */
        button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: scale(1) !important;
        }
        
        /* Success state animation */
        .success-pulse {
            animation: successPulse 0.6s ease-out;
        }
        
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Enhanced input effects */
        input:not(:placeholder-shown) {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        /* Checkbox animation */
        input[type="checkbox"]:checked {
            animation: checkBounce 0.3s ease-out;
        }

        @keyframes checkBounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.querySelector('button[type="submit"]');
            
            button.addEventListener('click', function(e) {
                const ripple = this.querySelector('.ripple');
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.width = '10px';
                ripple.style.height = '10px';
            });
            
            const input = document.getElementById('email');
            const label = document.querySelector('label[for="email"]');
            const passwordInput = document.getElementById('password');
            const passwordLabel = document.querySelector('label[for="password"]');
            
            input.addEventListener('focus', function() {
                label.style.transform = 'translateY(-2px)';
                label.style.fontSize = '0.813rem';
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    label.style.transform = 'translateY(0)';
                    label.style.fontSize = '0.875rem';
                }
            });
            
            passwordInput.addEventListener('focus', function() {
                passwordLabel.style.transform = 'translateY(-2px)';
                passwordLabel.style.fontSize = '0.813rem';
            });
            
            passwordInput.addEventListener('blur', function() {
                if (!this.value) {
                    passwordLabel.style.transform = 'translateY(0)';
                    passwordLabel.style.fontSize = '0.875rem';
                }
            });
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>