<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SaaS Perhutanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 min-h-screen flex items-center justify-center px-4 py-12">

    <div class="max-w-md w-full">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-block bg-emerald-600 p-4 rounded-full mb-4 shadow-lg">
                <i class="fas fa-tree text-white text-5xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-emerald-900 mb-2">SaaS Perhutanan</h1>
            <p class="text-gray-600">Monitoring Lahan & Hasil Hutan</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-t-4 border-emerald-500">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center space-x-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Buat Akun Baru</span>
                </h2>
                <p class="text-emerald-100 text-sm mt-1">Daftarkan akun Anda untuk mengakses sistem</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-user text-emerald-600"></i>
                            <span>Nama Lengkap</span>
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition duration-200 text-gray-900 placeholder-gray-400 @error('name') border-red-500 @enderror"
                        >
                        @error('name')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-2 rounded">
                                <p class="text-sm text-red-700 flex items-center space-x-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-envelope text-emerald-600"></i>
                            <span>Email Address</span>
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autocomplete="username"
                            placeholder="contoh@email.com"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition duration-200 text-gray-900 placeholder-gray-400 @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-2 rounded">
                                <p class="text-sm text-red-700 flex items-center space-x-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-lock text-emerald-600"></i>
                            <span>Password</span>
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition duration-200 text-gray-900 placeholder-gray-400 @error('password') border-red-500 @enderror"
                        >
                        @error('password')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-2 rounded">
                                <p class="text-sm text-red-700 flex items-center space-x-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-lock text-emerald-600"></i>
                            <span>Konfirmasi Password</span>
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Ketik ulang password Anda"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-emerald-200 focus:border-emerald-500 transition duration-200 text-gray-900 placeholder-gray-400"
                        >
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col space-y-3">
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                        >
                            <i class="fas fa-user-plus"></i>
                            <span>Daftar Sekarang</span>
                        </button>
                    </div>

                </form>

            </div>

            <!-- Card Footer -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-800 font-bold transition duration-200">
                        Login di sini <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </p>
            </div>

        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <p><i class="fas fa-shield-alt text-emerald-600"></i> Data Anda aman dan terenkripsi</p>
        </div>

    </div>

</body>
</html>
