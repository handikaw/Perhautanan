<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lahan - SaaS Manajemen Perhutanan</title>
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
                    <div class="flex items-center space-x-3 text-gray-700">
                        @if(Auth::check() && Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-10 w-10 rounded-full object-cover border-2 border-emerald-500">
                        @else
                            <i class="fas fa-user-circle text-3xl text-emerald-600"></i>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-sm font-medium">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</span>
                            <a href="{{ route('profile.edit') }}" class="text-xs text-emerald-600 hover:text-emerald-800 transition">Edit Profil</a>
                        </div>
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
            <div class="inline-block bg-yellow-100 p-4 rounded-full mb-4">
                <i class="fas fa-edit text-yellow-600 text-4xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-emerald-900 mb-2">Edit Data Lahan Perhutanan</h2>
            <p class="text-gray-600">Perbarui informasi lahan hutan: <span class="font-bold text-emerald-700">{{ $lahan->nama_lahan }}</span></p>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border-t-4 border-yellow-500">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-8 py-6">
                <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Form Edit Data Lahan</span>
                </h3>
                <p class="text-yellow-100 text-sm mt-1">ID Lahan: #{{ $lahan->id }} | Terakhir diupdate: {{ $lahan->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">
                
                <!-- FORM -->
                <form action="{{ route('forest.update', $lahan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Input 1: Nama Lahan -->
                    <div>
                        <label for="nama_lahan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-map-marked-alt text-emerald-600"></i>
                            <span>Nama Lahan / Blok Hutan</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama_lahan" 
                            id="nama_lahan" 
                            value="{{ old('nama_lahan', $lahan->nama_lahan) }}"
                            placeholder="Contoh: Blok Jati A1, Kawasan Mahoni Timur, dll"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition duration-200 text-gray-900 placeholder-gray-400 @error('nama_lahan') border-red-500 @enderror"
                        >
                        @error('nama_lahan')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-3 rounded">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800">Error Validasi:</p>
                                        <p class="text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                </div>
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                            <i class="fas fa-info-circle"></i>
                            <span>Nama lahan saat ini: <strong>{{ $lahan->nama_lahan }}</strong></span>
                        </p>
                    </div>

                    <!-- Input 2: Luas Hektar -->
                    <div>
                        <label for="luas_hektar" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-ruler-combined text-emerald-600"></i>
                            <span>Luas Wilayah (Hektar)</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="number" 
                                step="0.01" 
                                min="0.01"
                                name="luas_hektar" 
                                id="luas_hektar" 
                                value="{{ old('luas_hektar', $lahan->luas_hektar) }}"
                                placeholder="Contoh: 25.50"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition duration-200 text-gray-900 placeholder-gray-400 @error('luas_hektar') border-red-500 @enderror"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span class="text-gray-500 font-semibold">Ha</span>
                            </div>
                        </div>
                        @error('luas_hektar')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-3 rounded">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800">Error Validasi:</p>
                                        <p class="text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                </div>
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                            <i class="fas fa-info-circle"></i>
                            <span>Luas lahan saat ini: <strong>{{ number_format($lahan->luas_hektar, 2) }} Ha</strong></span>
                        </p>
                    </div>

                    <!-- Input 3: Status Alokasi -->
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 mb-2 flex items-center space-x-2">
                            <i class="fas fa-tag text-emerald-600"></i>
                            <span>Status Alokasi Lahan</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="status" 
                            id="status"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition duration-200 text-gray-900 @error('status') border-red-500 @enderror"
                        >
                            <option value="" disabled>-- Pilih Status Lahan --</option>
                            <option value="Produksi" {{ old('status', $lahan->status) == 'Produksi' ? 'selected' : '' }}>
                                🔵 Hutan Produksi (Penghasil Kayu & Hasil Hutan)
                            </option>
                            <option value="Konservasi" {{ old('status', $lahan->status) == 'Konservasi' ? 'selected' : '' }}>
                                🟢 Hutan Konservasi (Pelestarian Alam & Ekosistem)
                            </option>
                            <option value="Reboisasi" {{ old('status', $lahan->status) == 'Reboisasi' ? 'selected' : '' }}>
                                🟡 Zona Reboisasi (Penanaman & Penghijauan Kembali)
                            </option>
                        </select>
                        @error('status')
                            <div class="mt-2 bg-red-50 border-l-4 border-red-500 p-3 rounded">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                                    <div>
                                        <p class="text-sm font-semibold text-red-800">Error Validasi:</p>
                                        <p class="text-sm text-red-700">{{ $message }}</p>
                                    </div>
                                </div>
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                            <i class="fas fa-info-circle"></i>
                            <span>Status lahan saat ini: 
                                <strong class="
                                    @if($lahan->status == 'Produksi') text-blue-700
                                    @elseif($lahan->status == 'Konservasi') text-green-700
                                    @else text-yellow-700
                                    @endif
                                ">{{ $lahan->status }}</strong>
                            </span>
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-yellow-900">Perhatian Saat Edit Data:</p>
                                <ul class="text-xs text-yellow-800 mt-2 space-y-1 list-disc list-inside">
                                    <li>Pastikan data yang diubah sudah benar sebelum menyimpan</li>
                                    <li>Perubahan data akan langsung tersimpan ke database</li>
                                    <li>Riwayat perubahan akan tercatat di timestamp updated_at</li>
                                    <li>Jika ragu, klik tombol Batal untuk membatalkan perubahan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Data Sebelumnya (Before Update) -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="text-sm font-bold text-gray-700 mb-3 flex items-center space-x-2">
                            <i class="fas fa-history text-gray-600"></i>
                            <span>Data Lahan Sebelum Perubahan:</span>
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Nama Lahan</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $lahan->nama_lahan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Luas Wilayah</p>
                                <p class="text-sm font-semibold text-gray-800">{{ number_format($lahan->luas_hektar, 2) }} Ha</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Status Alokasi</p>
                                <p class="text-sm font-semibold 
                                    @if($lahan->status == 'Produksi') text-blue-700
                                    @elseif($lahan->status == 'Konservasi') text-green-700
                                    @else text-yellow-700
                                    @endif
                                ">{{ $lahan->status }}</p>
                            </div>
                        </div>
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
                            class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold rounded-lg transition duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl"
                        >
                            <i class="fas fa-save"></i>
                            <span>Update Data Lahan</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- Additional Info: Changelog -->
        <div class="mt-6 bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-500">
            <h4 class="text-sm font-bold text-emerald-800 mb-3 flex items-center space-x-2">
                <i class="fas fa-clock text-emerald-600"></i>
                <span>Informasi Timestamp</span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-plus text-blue-500"></i>
                    <span class="text-gray-600">Dibuat:</span>
                    <span class="font-semibold text-gray-800">{{ $lahan->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-check text-green-500"></i>
                    <span class="text-gray-600">Terakhir Update:</span>
                    <span class="font-semibold text-gray-800">{{ $lahan->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
