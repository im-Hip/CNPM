<x-guest-layout>
    <style>
        .vietnamese-text {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>

    <h2 class="text-3xl font-extrabold text-center text-blue-600 mb-6 vietnamese-text">
        ĐẶT LẠI MẬT KHẨU
    </h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 vietnamese-text">Email</label>
            <input id="email"
                   class="block mt-1 w-full px-4 py-2 bg-white text-black border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 vietnamese-text"
                   type="email"
                   name="email"
                   value="{{ old('email', $request->email) }}"
                   required
                   autofocus
                   autocomplete="username" />
            
            @error('email')
                <p class="mt-2 text-sm text-red-500 vietnamese-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700 vietnamese-text">Mật khẩu mới</label>
            <input id="password"
                   class="block mt-1 w-full px-4 py-2 bg-white text-black border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 vietnamese-text"
                   type="password"
                   name="password"
                   required
                   autocomplete="new-password"
                   placeholder="Nhập mật khẩu mới của bạn" />

            @error('password')
                <p class="mt-2 text-sm text-red-500 vietnamese-text">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700 vietnamese-text">Xác nhận mật khẩu mới</label>
            <input id="password_confirmation"
                   class="block mt-1 w-full px-4 py-2 bg-white text-black border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 vietnamese-text"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   placeholder="Nhập lại mật khẩu mới" />

            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-500 vietnamese-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit"
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 vietnamese-text">
                Đặt lại mật khẩu
            </button>
        </div>
    </form>
</x-guest-layout>