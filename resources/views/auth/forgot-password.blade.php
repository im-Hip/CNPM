<x-guest-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 bg-clip-text text-transparent mb-8 animate-gradient text-center animate-fadeInDown whitespace-nowrap inline-block px-4 py-2"
        style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif; font-kerning: none; letter-spacing: -0.02em; line-height: 1.1; text-transform: uppercase;">
        Quên mật khẩu
    </h2>

    <x-auth-session-status class="mb-4 animate-fadeIn" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div class="group animate-slideInLeft">
            <label for="email" class="block font-semibold text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                Email
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 transition-colors duration-300 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                       placeholder="Nhập email đã đăng ký tài khoản"
                       style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;"
                />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2 animate-shake" />
        </div>

        <!-- Button Gửi liên kết -->
        <div class="flex items-center justify-end mt-6 animate-slideInRight">
            <button type="submit"
                    class="w-full relative overflow-hidden px-6 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 bg-[length:200%_100%] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wide shadow-lg shadow-blue-500/40 transition-all duration-500 hover:bg-[position:100%_0] hover:shadow-2xl hover:shadow-blue-600/50 hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-500/50 active:scale-95 group/btn">
                <span class="relative z-10 flex items-center justify-center"
                      style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                    <svg class="mr-2 w-5 h-5 transition-transform duration-300 group-hover/btn:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Yêu cầu đặt lại mật khẩu
                    <svg class="ml-2 w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            </button>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center mt-6 animate-fadeInUp">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-all duration-300 group/link"
               style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                <svg class="w-4 h-4 mr-1 transition-transform duration-300 group-hover/link:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại đăng nhập
            </a>
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
        
        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out 0.3s both;
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
    </style>

    <script>
        // Add ripple effect on button click
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
            
            // Add floating label effect
            const input = document.getElementById('email');
            const label = document.querySelector('label[for="email"]');
            
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
        });
    </script>
</x-guest-layout>