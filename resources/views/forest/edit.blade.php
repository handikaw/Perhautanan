<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lahan &middot; Perhutani</title>

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
                    <div class="hidden sm:flex items-center space-x-3 text-canopy-100">
                        @if(Auth::check() && Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-9 w-9 rounded-full object-cover border border-canopy-700">
                        @else
                            <i class="fas fa-user-circle text-3xl text-canopy-300"></i>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-white">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</span>
                            <a href="{{ route('profile.edit') }}" class="text-xs text-canopy-300 hover:text-resin-400 transition">Edit Profil</a>
                        </div>
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
                <i class="fas fa-pen-to-square text-canopy-700 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-display font-semibold text-ink mb-1">Edit Data Lahan Perhutanan</h2>
            <p class="text-bark-600 text-sm">Perbarui informasi lahan hutan: <span class="font-semibold text-canopy-700">{{ $lahan->nama_lahan }}</span></p>
        </div>

        <!-- FORM CARD -->
        <div class="bg-white rounded-md border border-bark-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-canopy-800 px-8 py-5">
                <h3 class="text-lg font-display font-semibold text-white flex items-center space-x-2">
                    <i class="fas fa-pencil"></i>
                    <span>Form Edit Data Lahan</span>
                </h3>
                <p class="text-canopy-200 text-sm mt-1 font-mono">#{{ $lahan->id }} &middot; Terakhir diupdate {{ $lahan->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">

                <!-- FORM -->
                <form action="{{ route('forest.update', $lahan->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Input 1: Nama Lahan -->
                    <div>
                        <label for="nama_lahan" class="field-label">
                            <i class="fas fa-signature text-bark-500 mr-1"></i>
                            <span>Nama Lahan / Blok Hutan</span>
                            <span class="text-clay-500 ml-1">*</span>
                        </label>
                        <input
                            type="text"
                            name="nama_lahan"
                            id="nama_lahan"
                            value="{{ old('nama_lahan', $lahan->nama_lahan) }}"
                            placeholder="Contoh: Blok Jati A1, Kawasan Mahoni Timur, dll"
                            class="field-input @error('nama_lahan') !border-clay-500 !ring-clay-100 @enderror"
                        >
                        @error('nama_lahan')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-3 rounded-md">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-triangle-exclamation text-clay-600 mt-0.5"></i>
                                    <p class="text-sm text-clay-700">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-bark-500 flex items-center space-x-1">
                            <i class="fas fa-circle-info"></i>
                            <span>Nama saat ini: <strong class="text-ink">{{ $lahan->nama_lahan }}</strong></span>
                        </p>
                    </div>

                    <!-- Input 2: Luas Hektar -->
                    <div>
                        <label for="luas_hektar" class="field-label">
                            <i class="fas fa-ruler-combined text-bark-500 mr-1"></i>
                            <span>Luas Wilayah (Hektar)</span>
                            <span class="text-clay-500 ml-1">*</span>
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
                                class="field-input pr-10 @error('luas_hektar') !border-clay-500 !ring-clay-100 @enderror"
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <span class="text-bark-500 text-sm font-semibold">Ha</span>
                            </div>
                        </div>
                        @error('luas_hektar')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-3 rounded-md">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-triangle-exclamation text-clay-600 mt-0.5"></i>
                                    <p class="text-sm text-clay-700">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-bark-500 flex items-center space-x-1">
                            <i class="fas fa-circle-info"></i>
                            <span>Luas saat ini: <strong class="text-ink">{{ number_format($lahan->luas_hektar, 2) }} Ha</strong></span>
                        </p>
                    </div>

                    <!-- Input 3: Status Alokasi -->
                    <div>
                        <label for="status" class="field-label">
                            <i class="fas fa-tag text-bark-500 mr-1"></i>
                            <span>Status Alokasi Lahan</span>
                            <span class="text-clay-500 ml-1">*</span>
                        </label>
                        <select
                            name="status"
                            id="status"
                            class="field-input @error('status') !border-clay-500 !ring-clay-100 @enderror"
                        >
                            <option value="" disabled>-- Pilih Status Lahan --</option>
                            <option value="Produksi" {{ old('status', $lahan->status) == 'Produksi' ? 'selected' : '' }}>
                                Hutan Produksi (Penghasil Kayu &amp; Hasil Hutan)
                            </option>
                            <option value="Konservasi" {{ old('status', $lahan->status) == 'Konservasi' ? 'selected' : '' }}>
                                Hutan Konservasi (Pelestarian Alam &amp; Ekosistem)
                            </option>
                            <option value="Reboisasi" {{ old('status', $lahan->status) == 'Reboisasi' ? 'selected' : '' }}>
                                Zona Reboisasi (Penanaman &amp; Penghijauan Kembali)
                            </option>
                        </select>
                        @error('status')
                            <div class="mt-2 bg-clay-50 border-l-2 border-clay-500 p-3 rounded-md">
                                <div class="flex items-start space-x-2">
                                    <i class="fas fa-triangle-exclamation text-clay-600 mt-0.5"></i>
                                    <p class="text-sm text-clay-700">{{ $message }}</p>
                                </div>
                            </div>
                        @enderror
                        <p class="mt-2 text-xs text-bark-500 flex items-center space-x-1">
                            <i class="fas fa-circle-info"></i>
                            <span>Status saat ini:</span>
                            <span class="status-badge status-{{ $lahan->status }}">{{ $lahan->status }}</span>
                        </p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-canopy-50 border-l-2 border-canopy-600 p-4 rounded-md">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-triangle-exclamation text-canopy-700 mt-0.5"></i>
                            <div>
                                <p class="text-sm font-semibold text-canopy-900">Perhatian Saat Edit Data:</p>
                                <ul class="text-xs text-canopy-800 mt-2 space-y-1 list-disc list-inside">
                                    <li>Pastikan data yang diubah sudah benar sebelum menyimpan</li>
                                    <li>Perubahan data akan langsung tersimpan ke database</li>
                                    <li>Riwayat perubahan akan tercatat di timestamp updated_at</li>
                                    <li>Jika ragu, klik tombol Batal untuk membatalkan perubahan</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Data Sebelumnya (Before Update) -->
                    <div class="bg-mist border border-bark-100 rounded-md p-4">
                        <h4 class="text-xs font-bold text-bark-600 uppercase tracking-wide mb-3 flex items-center space-x-2">
                            <i class="fas fa-clock-rotate-left"></i>
                            <span>Data Lahan Sebelum Perubahan</span>
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-[11px] text-bark-500 uppercase tracking-wide">Nama Lahan</p>
                                <p class="text-sm font-semibold text-ink">{{ $lahan->nama_lahan }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-bark-500 uppercase tracking-wide">Luas Wilayah</p>
                                <p class="text-sm font-mono font-semibold text-ink">{{ number_format($lahan->luas_hektar, 2) }} Ha</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-bark-500 uppercase tracking-wide">Status Alokasi</p>
                                <span class="status-badge status-{{ $lahan->status }}">{{ $lahan->status }}</span>
                            </div>
                        </div>
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
                            <span>Update Data Lahan</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- Additional Info: Changelog -->
        <div class="mt-6 bg-white rounded-md border border-bark-100 border-l-2 border-l-canopy-600 p-6">
            <h4 class="text-xs font-bold text-bark-600 uppercase tracking-wide mb-3 flex items-center space-x-2">
                <i class="fas fa-clock text-canopy-700"></i>
                <span>Informasi Timestamp</span>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-plus text-bark-500"></i>
                    <span class="text-bark-600">Dibuat:</span>
                    <span class="font-mono font-semibold text-ink">{{ $lahan->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-check text-canopy-600"></i>
                    <span class="text-bark-600">Terakhir Update:</span>
                    <span class="font-mono font-semibold text-ink">{{ $lahan->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

    </div>

    <style type="text/tailwindcss">
        .field-label { @apply flex items-center text-sm font-semibold text-ink mb-2; }
        .field-input { @apply w-full px-4 py-2.5 border border-bark-300/70 rounded-md bg-white focus:ring-1 focus:ring-canopy-600 focus:border-canopy-600 focus:outline-none transition text-ink placeholder-bark-300; }
        .btn-primary { @apply bg-canopy-700 hover:bg-canopy-800 text-white px-5 py-2.5 rounded-md font-semibold transition flex items-center space-x-2; }
        .btn-outline-neutral { @apply bg-white border border-bark-300 text-bark-600 hover:bg-mist px-5 py-2.5 rounded-md font-semibold transition flex items-center space-x-2; }

        .status-badge { @apply px-2.5 py-1 rounded text-xs font-bold border; }
        .status-Konservasi { @apply bg-canopy-50 text-canopy-800 border-canopy-300; }
        .status-Produksi { @apply bg-bark-100 text-bark-700 border-bark-300; }
        .status-Reboisasi { @apply bg-resin-100 text-resin-700 border-resin-300; }
    </style>

</body>
</html>