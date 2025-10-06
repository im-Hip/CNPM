<x-guest-layout>

    <h2 class="text-3xl font-extrabold text-center text-blue-600 mb-4">
        QUÊN MẬT KHẨU
    </h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>

            <input id="email"
                   class="block mt-1 w-full px-4 py-2 bg-white text-black border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   placeholder="Nhập email đã đăng ký tài khoản"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Gửi liên kết đặt lại mật khẩu
            </button>
        </div>
    </form>
</x-guest-layout>