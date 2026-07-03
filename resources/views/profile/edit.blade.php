<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SaaS Perhutanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-lg border-b-4 border-emerald-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="bg-emerald-600 p-2 rounded-lg">
                        <i class="fas fa-tree text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-emerald-800">SaaS Perhutanan</h1>
                        <p class="text-xs text-gray-500">Monitoring Lahan & Hasil Hutan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-emerald-700 font-medium transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                    <div class="flex items-center space-x-2 text-gray-700">
                        <i class="fas fa-user-circle text-2xl text-emerald-600"></i>
                        <span class="text-sm font-medium">{{ Auth::user()->name ?? 'Admin User' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- HEADER SECTION -->
        <div class="mb-8 text-center">
            <div class="inline-block bg-green-100 p-4 rounded-full mb-4">
                <i class="fas fa-user-edit text-green-600 text-4xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-emerald-900 mb-2">Edit Profil Pengguna</h2>
            <p class="text-gray-600">Perbarui informasi akun Anda</p>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('status') === 'profile-updated')
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-start space-x-3 animate-fade-in">
                <i class="fas fa-check-circle text-2xl mt-1"></i>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm">Profil Anda telah diperbarui.</p>
                </div>
            </div>
        @endif

        <!-- PROFILE FORM CARD -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-t-4 border-green-500 mb-6">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                    <i class="fas fa-id-card"></i>
                    <span>Informasi Profil</span>
                </h3>
                <p class="text-green-100 text-sm mt-1">Update nama dan email Anda</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">
                
                <!-- PROFILE UPDATE FORM -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-user text-green-600"></i>
                            <span>Nama Lengkap</span>
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $user->name) }}"
                            required 
                            autofocus
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-green-200 focus:border-green-500 transition duration-200 text-gray-900 @error('name') border-red-500 @enderror"
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

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-envelope text-green-600"></i>
                            <span>Email Address</span>
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-green-200 focus:border-green-500 transition duration-200 text-gray-900 @error('email') border-red-500 @enderror"
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

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t-2 border-gray-200">
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition duration-200 flex items-center space-x-2 shadow-md hover:shadow-lg"
                        >
                            <i class="fas fa-times-circle"></i>
                            <span>Batal</span>
                        </a>
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-lg transition duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl"
                        >
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- PASSWORD UPDATE CARD -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-t-4 border-green-500 mb-6">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-6">
                <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                    <i class="fas fa-key"></i>
                    <span>Update Password</span>
                </h3>
                <p class="text-green-100 text-sm mt-1">Ganti password untuk keamanan akun</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">
                
                <!-- PASSWORD UPDATE FORM -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-lock text-green-600"></i>
                            <span>Password Saat Ini</span>
                        </label>
                        <input 
                            id="current_password" 
                            type="password" 
                            name="current_password" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-green-200 focus:border-green-500 transition duration-200 text-gray-900 @error('current_password', 'updatePassword') border-red-500 @enderror"
                        >
                        @error('current_password', 'updatePassword')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-2 rounded">
                                <p class="text-sm text-red-700 flex items-center space-x-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-lock text-green-600"></i>
                            <span>Password Baru</span>
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-green-200 focus:border-green-500 transition duration-200 text-gray-900 @error('password', 'updatePassword') border-red-500 @enderror"
                        >
                        @error('password', 'updatePassword')
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
                            <i class="fas fa-lock text-green-600"></i>
                            <span>Konfirmasi Password Baru</span>
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-green-200 focus:border-green-500 transition duration-200 text-gray-900"
                        >
                    </div>

                    <!-- Info Box -->
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-shield-alt text-green-600 text-xl mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-green-900">Tips Keamanan Password:</p>
                                <ul class="text-xs text-green-800 mt-2 space-y-1 list-disc list-inside">
                                    <li>Gunakan minimal 8 karakter</li>
                                    <li>Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                                    <li>Jangan gunakan password yang mudah ditebak</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t-2 border-gray-200">
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-bold rounded-lg transition duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl"
                        >
                            <i class="fas fa-key"></i>
                            <span>Update Password</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>

</body>
</html>
