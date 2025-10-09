<x-guest-layout>
    <!-- Tiêu đề với gradient và animation -->
    <h2 class="text-4xl font-extrabold bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 bg-clip-text text-transparent mb-8 animate-gradient">
        ĐĂNG NHẬP
    </h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div class="group">
            <label for="email" class="block font-medium text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1">
                Email
            </label>

            <input id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="block mt-1 w-full px-4 py-3 bg-gradient-to-br from-white to-gray-50 text-black border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md"
                placeholder="Nhập địa chỉ email của bạn"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 group">
            <label for="password" class="block font-medium text-sm text-gray-700 mb-2 transition-all duration-300 group-focus-within:text-blue-600 group-focus-within:translate-x-1">
                Password
            </label>

            <input id="password"
                type="password"
                name="password"
                required autocomplete="current-password"
                class="block mt-1 w-full px-4 py-3 bg-gradient-to-br from-white to-gray-50 text-black border-2 border-gray-300 rounded-xl shadow-sm transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-400/30 focus:border-blue-500 focus:shadow-lg focus:shadow-blue-500/20 hover:border-gray-400 hover:shadow-md"
                placeholder="Nhập mật khẩu của bạn"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Quên mật khẩu -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group/check">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded-md border-2 border-gray-400 text-blue-600 shadow-sm focus:ring-4 focus:ring-blue-500/30 transition-all duration-200 hover:border-blue-500 hover:scale-110 cursor-pointer">
                <span class="ml-2 text-sm text-gray-600 transition-all duration-200 group-hover/check:text-gray-900 group-hover/check:translate-x-0.5">
                    Ghi nhớ đăng nhập
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-all duration-200 hover:underline decoration-2 underline-offset-4 hover:underline-offset-2 hover:scale-105 inline-block" 
                   href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>

        <!-- Button Đăng nhập -->
        <div class="flex items-center justify-end mt-6">
            <button type="submit"
                    class="w-full relative overflow-hidden px-6 py-3.5 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 bg-[length:200%_100%] border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest shadow-lg shadow-blue-500/40 transition-all duration-500 hover:bg-[position:100%_0] hover:shadow-2xl hover:shadow-blue-600/50 hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-500/50 active:scale-95 group/btn">
                <span class="relative z-10 flex items-center justify-center">
                    Đăng nhập
                    <svg class="ml-2 w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </span>
                
                <!-- Hiệu ứng sáng chạy -->
                <span class="absolute inset-0 w-full h-full">
                    <span class="absolute inset-0 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/30 to-transparent"></span>
                </span>
            </button>
        </div>
    </form>

    <style>
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
        
        .animate-gradient {
            animation: gradient 3s ease infinite;
        }
    </style>
</x-guest-layout>