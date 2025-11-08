<x-guest-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 bg-clip-text text-transparent mb-8 animate-gradient text-center animate-fadeInDown whitespace-nowrap inline-block px-4 py-2"
        style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif; font-kerning: none; letter-spacing: -0.02em; line-height: 1.1; text-transform: uppercase;">
        ĐẶT LẠI MẬT KHẨU
    </h2>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
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
                       class="block w-full pl-12 pr-4 py-3.5 bg-gradient-to-br from-white to-gray-50 text-gray-900 border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md placeholder:text-gray-400"
                       type="email"
                       name="email"
                       value="{{ old('email', $request->email) }}"
                       required
                       autofocus
                       autocomplete="username"
                       placeholder="Nhập địa chỉ email của bạn"
                       style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;" />
                
                @error('email')
                    <p class="mt-2 text-sm text-red-500 animate-shake" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="group animate-slideInLeft delay-100">
            <label for="password" class="block font-semibold text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                Mật khẩu mới
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-blue-500 group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                
                <input id="password"
                       class="block w-full pl-12 pr-12 py-3.5 bg-gradient-to-br from-white to-gray-50 text-gray-900 border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md placeholder:text-gray-400"
                       type="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       placeholder="Nhập mật khẩu mới của bạn"
                       style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;" />

                <!-- Toggle Password Visibility -->
                <button type="button" 
                        onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-500 transition-all duration-300 focus:outline-none group/eye">
                    <svg id="eye-open-password" class="w-5 h-5 transition-all duration-300 group-hover/eye:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eye-closed-password" class="w-5 h-5 hidden transition-all duration-300 group-hover/eye:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>

                @error('password')
                    <p class="mt-2 text-sm text-red-500 animate-shake" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Strength Suggestions -->
            <div id="password-suggestions" class="mt-3 space-y-2 hidden">
                <div class="flex items-start space-x-2 text-sm">
                    <svg id="check-length" class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span id="text-length" class="text-red-500" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Tối thiểu 8 ký tự</span>
                </div>
                <div class="flex items-start space-x-2 text-sm">
                    <svg id="check-uppercase" class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span id="text-uppercase" class="text-red-500" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Ít nhất 1 chữ in hoa</span>
                </div>
                <div class="flex items-start space-x-2 text-sm">
                    <svg id="check-lowercase" class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span id="text-lowercase" class="text-red-500" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Ít nhất 1 chữ thường</span>
                </div>
                <div class="flex items-start space-x-2 text-sm">
                    <svg id="check-number" class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span id="text-number" class="text-red-500" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Ít nhất 1 chữ số</span>
                </div>
                <div class="flex items-start space-x-2 text-sm">
                    <svg id="check-special" class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span id="text-special" class="text-red-500" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Ít nhất 1 ký tự đặc biệt (!@#$%^&*)</span>
                </div>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="group animate-slideInLeft delay-200">
            <label for="password_confirmation" class="block font-semibold text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1"
                   style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                Xác nhận mật khẩu mới
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 transition-all duration-300 group-focus-within:text-blue-500 group-focus-within:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                
                <input id="password_confirmation"
                       class="block w-full pl-12 pr-12 py-3.5 bg-gradient-to-br from-white to-gray-50 text-gray-900 border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md placeholder:text-gray-400"
                       type="password"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Nhập lại mật khẩu mới"
                       style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;" />

                <!-- Toggle Password Visibility -->
                <button type="button" 
                        onclick="togglePassword('password_confirmation')"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-500 transition-all duration-300 focus:outline-none group/eye">
                    <svg id="eye-open-confirm" class="w-5 h-5 transition-all duration-300 group-hover/eye:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="eye-closed-confirm" class="w-5 h-5 hidden transition-all duration-300 group-hover/eye:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>

                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-500 animate-shake" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Match Warning -->
            <div id="password-match-warning" class="mt-3 hidden">
                <div class="flex items-start space-x-2 text-sm">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-500" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Mật khẩu không khớp</span>
                </div>
            </div>

            <!-- Password Match Success -->
            <div id="password-match-success" class="mt-3 hidden">
                <div class="flex items-start space-x-2 text-sm">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-600" style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">Mật khẩu khớp</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 animate-slideInRight">
            <button type="submit"
                    class="w-full relative overflow-hidden px-6 py-4 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 bg-[length:200%_100%] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wide shadow-lg shadow-blue-500/40 transition-all duration-500 hover:bg-[position:100%_0] hover:shadow-2xl hover:shadow-blue-600/50 hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-500/50 active:scale-95 group/btn"
                    style="font-family: 'Roboto', 'Noto Sans', system-ui, -apple-system, sans-serif;">
                <span class="relative z-10 flex items-center justify-center">
                    Đặt lại mật khẩu
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

        .delay-200 {
            animation-delay: 0.4s !important;
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.querySelector('button[type="submit"]');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const passwordSuggestions = document.getElementById('password-suggestions');
            const passwordMatchWarning = document.getElementById('password-match-warning');
            const passwordMatchSuccess = document.getElementById('password-match-success');
            
            // Ripple effect
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
            
            // Label animations
            const emailInput = document.getElementById('email');
            const emailLabel = document.querySelector('label[for="email"]');
            const passwordLabel = document.querySelector('label[for="password"]');
            const confirmPasswordLabel = document.querySelector('label[for="password_confirmation"]');
            
            emailInput.addEventListener('focus', function() {
                emailLabel.style.transform = 'translateY(-2px)';
                emailLabel.style.fontSize = '0.813rem';
            });
            
            emailInput.addEventListener('blur', function() {
                if (!this.value) {
                    emailLabel.style.transform = 'translateY(0)';
                    emailLabel.style.fontSize = '0.875rem';
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
            
            confirmPasswordInput.addEventListener('focus', function() {
                confirmPasswordLabel.style.transform = 'translateY(-2px)';
                confirmPasswordLabel.style.fontSize = '0.813rem';
            });
            
            confirmPasswordInput.addEventListener('blur', function() {
                if (!this.value) {
                    confirmPasswordLabel.style.transform = 'translateY(0)';
                    confirmPasswordLabel.style.fontSize = '0.875rem';
                }
            });

            // Password strength validation
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                
                if (password.length > 0) {
                    passwordSuggestions.classList.remove('hidden');
                    
                    // Check length (minimum 8 characters)
                    updateRequirement('length', password.length >= 8);
                    
                    // Check uppercase
                    updateRequirement('uppercase', /[A-Z]/.test(password));
                    
                    // Check lowercase
                    updateRequirement('lowercase', /[a-z]/.test(password));
                    
                    // Check number
                    updateRequirement('number', /[0-9]/.test(password));
                    
                    // Check special character
                    updateRequirement('special', /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password));
                } else {
                    passwordSuggestions.classList.add('hidden');
                }
                
                // Check password match
                checkPasswordMatch();
            });

            // Password confirmation validation
            confirmPasswordInput.addEventListener('input', function() {
                checkPasswordMatch();
            });

            function updateRequirement(type, isValid) {
                const checkIcon = document.getElementById('check-' + type);
                const textElement = document.getElementById('text-' + type);
                
                if (isValid) {
                    // Valid - show green checkmark
                    checkIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
                    checkIcon.classList.remove('text-red-500');
                    checkIcon.classList.add('text-green-500');
                    textElement.classList.remove('text-red-500');
                    textElement.classList.add('text-green-600');
                } else {
                    // Invalid - show red X
                    checkIcon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                    checkIcon.classList.remove('text-green-500');
                    checkIcon.classList.add('text-red-500');
                    textElement.classList.remove('text-green-600');
                    textElement.classList.add('text-red-500');
                }
            }

            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (confirmPassword.length > 0) {
                    if (password === confirmPassword) {
                        // Passwords match
                        passwordMatchWarning.classList.add('hidden');
                        passwordMatchSuccess.classList.remove('hidden');
                        confirmPasswordInput.classList.remove('border-red-500');
                        confirmPasswordInput.classList.add('border-green-500');
                    } else {
                        // Passwords don't match
                        passwordMatchWarning.classList.remove('hidden');
                        passwordMatchSuccess.classList.add('hidden');
                        confirmPasswordInput.classList.remove('border-green-500');
                        confirmPasswordInput.classList.add('border-red-500');
                    }
                } else {
                    // No confirmation password entered yet
                    passwordMatchWarning.classList.add('hidden');
                    passwordMatchSuccess.classList.add('hidden');
                    confirmPasswordInput.classList.remove('border-red-500', 'border-green-500');
                }
            }
        });

        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeOpen = document.getElementById('eye-open-' + (fieldId === 'password' ? 'password' : 'confirm'));
            const eyeClosed = document.getElementById('eye-closed-' + (fieldId === 'password' ? 'password' : 'confirm'));
            
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