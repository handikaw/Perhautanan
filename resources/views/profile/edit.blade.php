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
            <div class="bg-gradient-to<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil &middot; Perhutani</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        canopy: { 50:'#eef1ea', 100:'#dbe2d0', 200:'#c3d1b1', 300:'#93aa7c', 400:'#6f8c5c', 500:'#4b6b3f', 600:'#3a5730', 700:'#2c4526', 800:'#22371e', 900:'#182818' },
                        bark:   { 50:'#f5efe6', 100:'#ece1d3', 200:'#d9c7ac', 300:'#c3a688', 400:'#a8825d', 500:'#8a6242', 600:'#6f4d33', 700:'#573c28', 800:'#402c1c', 900:'#2b1d12' },
                        resin:  { 50:'#faf3de', 100:'#f1e4c0', 200:'#e6cd8e', 300:'#dcbb6c', 400:'#cba043', 500:'#b8862f', 600:'#976c22', 700:'#7a561b', 800:'#5c4014', 900:'#3d2b0d' },
                        clay:   { 50:'#f7ece6', 100:'#ecdcd0', 200:'#d9b8a5', 300:'#c4937a', 400:'#b16a4e', 500:'#a1462a', 600:'#833a22', 700:'#6b2f1b', 800:'#4d2213', 900:'#33170c' },
                        mist:   '#f4efe3',
                        ink:    '#26211a'
                    },
                    fontFamily: {
                        display: ['"Fraunces"', 'serif'],
                        body: ['"Public Sans"', 'sans-serif'],
                        mono: ['"IBM Plex Mono"', 'monospace']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Public+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-mist font-body text-ink min-h-screen" style="background-image:radial-gradient(rgba(38,33,26,0.05) 1px, transparent 1px); background-size: 20px 20px;">

    <!-- NAVBAR -->
    <nav class="bg-canopy-900 border-b border-bark-500/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-resin-500/70 flex items-center justify-center">
                        <i class="fas fa-tree text-resin-500 text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-display font-semibold text-white leading-tight">Perhutani</h1>
                        <p class="text-[11px] text-canopy-300">Monitoring Lahan &amp; Hasil Hutan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-canopy-200 hover:text-white font-medium transition duration-200 flex items-center space-x-2 text-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">Kembali ke Dashboard</span>
                    </a>
                    <div class="hidden sm:flex items-center space-x-2 text-canopy-100">
                        <i class="fas fa-user-circle text-2xl text-canopy-300"></i>
                        <span class="text-sm font-medium">{{ Auth::user()->name ?? 'Admin User' }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="border border-clay-500 text-clay-500 hover:bg-clay-500 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- HEADER SECTION -->
        <div class="mb-8 text-center">
            <div class="inline-flex w-16 h-16 rounded-full border-2 border-canopy-300 items-center justify-center mb-4 bg-white">
                <i class="fas fa-user-pen text-canopy-700 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-display font-semibold text-ink mb-1">Edit Profil Pengguna</h2>
            <p class="text-bark-600 text-sm">Perbarui informasi akun Anda</p>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if(session('status') === 'profile-updated')
            <div class="mb-6 bg-canopy-50 border-l-2 border-canopy-600 text-canopy-800 p-4 rounded-md flex items-start space-x-3">
                <i class="fas fa-circle-check text-xl mt-0.5"></i>
                <div>
                    <p class="font-semibold text-sm">Berhasil!</p>
                    <p class="text-sm">Profil Anda telah diperbarui.</p>
                </div>
            </div>
        @endif

        <!-- PROFILE FORM CARD -->
        <div class="bg-white rounded-md border border-bark-100 overflow-hidden mb-6">

            <!-- Card Header -->
            <div class="bg-canopy-800 px-8 py-5">
                <h3 class="text-lg font-display font-semibold text-white flex items-center space-x-2">
                    <i class="fas fa-id-card"></i>
                    <span>Informasi Profil</span>
                </h3>
                <p class="text-canopy-200 text-sm mt-1">Update nama dan email Anda</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">

                <!-- PROFILE UPDATE FORM -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <!-- Name -->
                    <div>
                        <label for="name" class="field-label">
                            <i class="fas fa-user text-bark-500 mr-1"></i>
                            <span>Nama Lengkap</span>
                        </label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            autofocus
                            class="field-input @error('name') !border-clay-500 !ring-clay-100 @enderror"
                        >
                        @error('name')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-2 rounded-md">
                                <p class="text-sm text-clay-700 flex items-center space-x-1">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="field-label">
                            <i class="fas fa-envelope text-bark-500 mr-1"></i>
                            <span>Email</span>
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="field-input @error('email') !border-clay-500 !ring-clay-100 @enderror"
                        >
                        @error('email')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-2 rounded-md">
                                <p class="text-sm text-clay-700 flex items-center space-x-1">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-5 border-t border-bark-100">
                        <a
                            href="{{ route('dashboard') }}"
                            class="btn-outline-neutral"
                        >
                            <i class="fas fa-xmark"></i>
                            <span>Batal</span>
                        </a>
                        <button
                            type="submit"
                            class="btn-primary"
                        >
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- PASSWORD UPDATE CARD -->
        <div class="bg-white rounded-md border border-bark-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-bark-700 px-8 py-5">
                <h3 class="text-lg font-display font-semibold text-white flex items-center space-x-2">
                    <i class="fas fa-key"></i>
                    <span>Update Password</span>
                </h3>
                <p class="text-bark-200 text-sm mt-1">Ganti password untuk keamanan akun</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">

                <!-- PASSWORD UPDATE FORM -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="field-label">
                            <i class="fas fa-lock text-bark-500 mr-1"></i>
                            <span>Password Saat Ini</span>
                        </label>
                        <input
                            id="current_password"
                            type="password"
                            name="current_password"
                            required
                            class="field-input @error('current_password', 'updatePassword') !border-clay-500 !ring-clay-100 @enderror"
                        >
                        @error('current_password', 'updatePassword')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-2 rounded-md">
                                <p class="text-sm text-clay-700 flex items-center space-x-1">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="field-label">
                            <i class="fas fa-lock text-bark-500 mr-1"></i>
                            <span>Password Baru</span>
                        </label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="field-input @error('password', 'updatePassword') !border-clay-500 !ring-clay-100 @enderror"
                        >
                        @error('password', 'updatePassword')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-2 rounded-md">
                                <p class="text-sm text-clay-700 flex items-center space-x-1">
                                    <i class="fas fa-triangle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="field-label">
                            <i class="fas fa-lock text-bark-500 mr-1"></i>
                            <span>Konfirmasi Password Baru</span>
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            class="field-input"
                        >
                    </div>

                    <!-- Info Box -->
                    <div class="bg-canopy-50 border-l-2 border-canopy-600 p-4 rounded-md">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-shield-halved text-canopy-700 mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-canopy-900">Tips Keamanan Password:</p>
                                <ul class="text-xs text-canopy-800 mt-2 space-y-1 list-disc list-inside">
                                    <li>Gunakan minimal 8 karakter</li>
                                    <li>Kombinasikan huruf besar, kecil, angka, dan simbol</li>
                                    <li>Jangan gunakan password yang mudah ditebak</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-5 border-t border-bark-100">
                        <button
                            type="submit"
                            class="bg-bark-600 hover:bg-bark-700 text-white px-5 py-2.5 rounded-md font-semibold transition flex items-center space-x-2"
                        >
                            <i class="fas fa-key"></i>
                            <span>Update Password</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <style type="text/tailwindcss">
        .field-label { @apply flex items-center text-sm font-semibold text-ink mb-2; }
        .field-input { @apply w-full px-4 py-2.5 border border-bark-300/70 rounded-md bg-white focus:ring-1 focus:ring-canopy-600 focus:border-canopy-600 focus:outline-none transition text-ink; }
        .btn-primary { @apply bg-canopy-700 hover:bg-canopy-800 text-white px-5 py-2.5 rounded-md font-semibold transition flex items-center space-x-2; }
        .btn-outline-neutral { @apply bg-white border border-bark-300 text-bark-600 hover:bg-mist px-5 py-2.5 rounded-md font-semibold transition flex items-center space-x-2; }
    </style>

</body>
</html>-r from-green-500 to-emerald-500 px-8 py-6">
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
