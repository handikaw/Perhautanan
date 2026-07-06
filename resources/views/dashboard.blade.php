<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SaaS Manajemen Perhutanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 min-h-screen">

    <!-- ============ KOP SURAT (PRINT ONLY) ============ -->
    <div class="print-header">
        <div class="print-header-inner">
            <i class="fas fa-tree"></i>
            <div class="print-header-text">
                <h1>PERUM PERHUTANI</h1>
                <p>Sistem Monitoring &amp; Manajemen Lahan serta Hasil Hutan</p>
                <p class="print-header-sub">Dokumen dicetak otomatis oleh sistem &middot; <span id="printDate">-</span></p>
            </div>
        </div>
        <hr>
    </div>

    <!-- ============ NAVBAR ============ -->
    <nav class="bg-white shadow-lg border-b-4 border-emerald-500 sticky top-0 z-50 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3 cursor-pointer" onclick="switchPage('dashboard')">
                    <div class="bg-emerald-600 p-2 rounded-lg">
                        <i class="fas fa-tree text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-emerald-800">Perhutani</h1>
                        <p class="text-xs text-gray-500">Monitoring Lahan &amp; Hasil Hutan</p>
                    </div>
                </div>

                <div class="hidden md:flex space-x-1 bg-gray-100 p-1 rounded-xl">
                    <button id="tab-dashboard" onclick="switchPage('dashboard')" class="px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 bg-emerald-600 text-white shadow">
                        <i class="fas fa-home"></i> <span>Dashboard</span>
                    </button>
                    <button id="tab-tambah-lahan" onclick="switchPage('tambah-lahan')" class="px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-plus-circle"></i> <span>Tambah Lahan</span>
                    </button>
                    <button id="tab-analisis" onclick="switchPage('analisis')" class="px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 text-gray-600 hover:bg-gray-200">
                        <i class="fas fa-chart-pie"></i> <span>Analisis Lahan</span>
                    </button>
                </div>

                <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg text-emerald-600 hover:bg-emerald-50 transition" onclick="toggleMobileMenu()" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="hidden md:flex items-center space-x-4">
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
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200 shadow-md flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- ============ MOBILE MENU ============ -->
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg border-b-2 border-emerald-500 no-print">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-2">
            <button id="mtab-dashboard" onclick="switchPage('dashboard'); toggleMobileMenu();" class="w-full text-left bg-emerald-50 text-emerald-800 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2">
                <i class="fas fa-home w-5"></i> <span>Dashboard Utama</span>
            </button>
            <button id="mtab-tambah-lahan" onclick="switchPage('tambah-lahan'); toggleMobileMenu();" class="w-full text-left text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2">
                <i class="fas fa-plus-circle w-5"></i> <span>Manajemen Lahan</span>
            </button>
            <button id="mtab-analisis" onclick="switchPage('analisis'); toggleMobileMenu();" class="w-full text-left text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2">
                <i class="fas fa-chart-pie w-5"></i> <span>Analisis Data Lahan</span>
            </button>

            <div class="border-t border-gray-200 pt-3 mt-2">
                <div class="flex items-center space-x-3 px-4 py-2">
                    @if(Auth::check() && Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-12 w-12 rounded-full object-cover border-2 border-emerald-500">
                    @else
                        <i class="fas fa-user-circle text-4xl text-emerald-600"></i>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-900">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</span>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-emerald-600 hover:text-emerald-800 transition">Edit Profil</a>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200 pt-2">
                @csrf
                <button type="submit" class="block w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-lg font-medium text-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- ============ FLASH MESSAGES ============ -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 space-y-3 no-print">
        @if(session('success'))
            <div id="flashSuccess" class="relative overflow-hidden bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-start space-x-3">
                <i class="fas fa-check-circle text-2xl mt-1"></i>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="dismissFlash('flashSuccess')" class="ml-auto text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
                <div class="absolute bottom-0 left-0 h-1 bg-green-500" id="flashSuccessBar" style="width:100%"></div>
            </div>
        @endif
        @if(session('error'))
            <div id="flashError" class="relative overflow-hidden bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md flex items-start space-x-3">
                <i class="fas fa-exclamation-circle text-2xl mt-1"></i>
                <div>
                    <p class="font-semibold">Terjadi Kesalahan</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                <button onclick="dismissFlash('flashError')" class="ml-auto text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
                <div class="absolute bottom-0 left-0 h-1 bg-red-500" id="flashErrorBar" style="width:100%"></div>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- ============ DASHBOARD PAGE ============ -->
        <section id="page-dashboard" class="page-section space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                <div>
                    <h2 class="text-3xl font-bold text-emerald-900 mb-2">Dashboard Lahan Perhutanan</h2>
                    <p class="text-gray-600">Kelola dan pantau data lahan hutan Anda secara real-time</p>
                </div>
                <div class="text-sm text-gray-500 flex items-center space-x-2 bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-100 no-print">
                    <i class="fas fa-clock text-emerald-500"></i>
                    <span id="liveClock">-</span>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500 hover:shadow-xl hover:-translate-y-0.5 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Lahan</p>
                            <p class="text-4xl font-bold text-emerald-700 mt-2">{{ $forestLands->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Blok hutan terdaftar</p>
                        </div>
                        <div class="bg-emerald-100 p-4 rounded-full"><i class="fas fa-layer-group text-emerald-600 text-3xl"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500 hover:shadow-xl hover:-translate-y-0.5 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Luas</p>
                            <p class="text-4xl font-bold text-green-700 mt-2">{{ number_format($forestLands->sum('luas_hektar'), 2) }}</p>
                            <p class="text-xs text-gray-400 mt-1">Hektar (Ha)</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full"><i class="fas fa-chart-area text-green-600 text-3xl"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-teal-500 hover:shadow-xl hover:-translate-y-0.5 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Rata-rata Luas</p>
                            <p class="text-4xl font-bold text-teal-700 mt-2">{{ $forestLands->count() > 0 ? number_format($forestLands->avg('luas_hektar'), 2) : '0.00' }}</p>
                            <p class="text-xs text-gray-400 mt-1">Hektar / lahan</p>
                        </div>
                        <div class="bg-teal-100 p-4 rounded-full"><i class="fas fa-balance-scale text-teal-600 text-3xl"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-amber-500 hover:shadow-xl hover:-translate-y-0.5 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Status Dominan</p>
                            <p class="text-3xl font-bold text-amber-700 mt-2">
                                {{ $forestLands->count() > 0 ? $forestLands->countBy('status')->sortDesc()->keys()->first() : '-' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Status terbanyak</p>
                        </div>
                        <div class="bg-amber-100 p-4 rounded-full"><i class="fas fa-seedling text-amber-600 text-3xl"></i></div>
                    </div>
                </div>
            </div>

            <!-- Quick status chips -->
            <div class="flex flex-wrap gap-3 no-print" id="statusChips">
                <button data-chip="all" onclick="setChipFilter('all')" class="chip-btn px-4 py-2 rounded-full text-sm font-semibold border-2 border-emerald-600 bg-emerald-600 text-white shadow-sm transition">
                    <i class="fas fa-layer-group mr-1"></i> Semua <span class="chip-count">({{ $forestLands->count() }})</span>
                </button>
                <button data-chip="Konservasi" onclick="setChipFilter('Konservasi')" class="chip-btn px-4 py-2 rounded-full text-sm font-semibold border-2 border-green-500 text-green-700 bg-white hover:bg-green-50 transition">
                    <i class="fas fa-leaf mr-1"></i> Konservasi <span class="chip-count">({{ $forestLands->where('status', 'Konservasi')->count() }})</span>
                </button>
                <button data-chip="Produksi" onclick="setChipFilter('Produksi')" class="chip-btn px-4 py-2 rounded-full text-sm font-semibold border-2 border-blue-500 text-blue-700 bg-white hover:bg-blue-50 transition">
                    <i class="fas fa-industry mr-1"></i> Produksi <span class="chip-count">({{ $forestLands->where('status', 'Produksi')->count() }})</span>
                </button>
                <button data-chip="Reboisasi" onclick="setChipFilter('Reboisasi')" class="chip-btn px-4 py-2 rounded-full text-sm font-semibold border-2 border-yellow-500 text-yellow-700 bg-white hover:bg-yellow-50 transition">
                    <i class="fas fa-tree mr-1"></i> Reboisasi <span class="chip-count">({{ $forestLands->where('status', 'Reboisasi')->count() }})</span>
                </button>
            </div>

            <!-- Aktivitas Terbaru & Ringkasan Catatan -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 no-print">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500">
                    <h3 class="text-lg font-bold text-emerald-900 flex items-center mb-4">
                        <i class="fas fa-clock-rotate-left text-emerald-600 mr-2"></i> Aktivitas Pembaruan Lahan Terbaru
                    </h3>
                    <ul id="recentActivityList" class="divide-y divide-gray-100">
                        <li class="py-3 text-sm text-gray-400 flex items-center space-x-2">
                            <i class="fas fa-circle-notch fa-spin"></i><span>Memuat aktivitas terbaru...</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-amber-500">
                    <h3 class="text-lg font-bold text-emerald-900 flex items-center mb-4">
                        <i class="fas fa-clipboard-check text-amber-600 mr-2"></i> Catatan Pengawasan
                    </h3>
                    <ul id="watchNotesList" class="space-y-3 text-sm text-gray-700">
                        <li class="text-gray-400 flex items-center space-x-2"><i class="fas fa-circle-notch fa-spin"></i><span>Menganalisis data...</span></li>
                    </ul>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card bg-white rounded-xl shadow-lg p-6 no-print">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-emerald-900 flex items-center">
                        <i class="fas fa-filter text-emerald-600 mr-2"></i> Filter &amp; Pencarian
                    </h3>
                    <button onclick="resetFilters()" class="text-sm text-gray-600 hover:text-emerald-600 transition flex items-center">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-search mr-1"></i> Cari Nama Lahan</label>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Ketik nama lahan... (tekan /)" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition pr-9">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-300"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-tag mr-1"></i> Status Lahan</label>
                        <select id="statusFilter" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition">
                            <option value="all">Semua Status</option>
                            <option value="Konservasi">Konservasi</option>
                            <option value="Produksi">Produksi</option>
                            <option value="Reboisasi">Reboisasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-ruler-combined mr-1"></i> Ukuran Lahan</label>
                        <select id="sizeFilter" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition">
                            <option value="all">Semua Ukuran</option>
                            <option value="small">Kecil (&lt; 10 Ha)</option>
                            <option value="medium">Sedang (10-50 Ha)</option>
                            <option value="large">Besar (&gt; 50 Ha)</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-4 pt-4 border-t border-gray-100 gap-3">
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <label for="perPage" class="font-medium text-gray-700">Baris per halaman:</label>
                        <select id="perPage" class="border-2 border-gray-300 rounded-lg px-2 py-1 focus:border-emerald-500 focus:outline-none">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="9999">Semua</option>
                        </select>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button onclick="exportCSV()" class="bg-white border-2 border-emerald-600 text-emerald-700 hover:bg-emerald-50 px-3 py-2 rounded-lg text-sm font-semibold transition flex items-center space-x-1">
                            <i class="fas fa-file-csv"></i> <span>Export CSV</span>
                        </button>
                        <button onclick="printPage()" class="bg-white border-2 border-gray-300 text-gray-600 hover:bg-gray-50 px-3 py-2 rounded-lg text-sm font-semibold transition flex items-center space-x-1">
                            <i class="fas fa-print"></i> <span>Cetak</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk action bar -->
            <div id="bulkActionBar" class="hidden bg-emerald-700 text-white rounded-xl shadow-lg px-5 py-3 items-center justify-between no-print">
                <span class="text-sm font-semibold"><i class="fas fa-check-double mr-2"></i><span id="bulkCount">0</span> lahan dipilih</span>
                <div class="flex items-center gap-2">
                    <button onclick="bulkExportSelected()" class="bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg text-sm font-semibold transition"><i class="fas fa-file-csv mr-1"></i> Export</button>
                    <button onclick="bulkDeleteSelected()" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg text-sm font-semibold transition"><i class="fas fa-trash-alt mr-1"></i> Hapus</button>
                    <button onclick="clearSelection()" class="bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg text-sm font-semibold transition"><i class="fas fa-xmark mr-1"></i> Batal</button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                            <i class="fas fa-table"></i> <span>Daftar Lahan Perhutanan</span>
                        </h3>
                    </div>
                    <button onclick="switchPage('tambah-lahan')" class="no-print bg-white text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg font-semibold text-xs shadow transition flex items-center space-x-1">
                        <i class="fas fa-plus"></i> <span>Catat Lahan</span>
                    </button>
                </div>

                @if($forestLands->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-4 text-left no-print"><input type="checkbox" id="selectAllRows" onchange="toggleSelectAll(this)" class="w-4 h-4 accent-emerald-600"></th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer select-none" onclick="setSort('nama_lahan')">
                                        Nama Lahan <i class="fas fa-sort ml-1 text-gray-400 sort-icon" data-sort-key="nama_lahan"></i>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer select-none" onclick="setSort('luas_hektar')">
                                        Luas (Ha) <i class="fas fa-sort ml-1 text-gray-400 sort-icon" data-sort-key="luas_hektar"></i>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider cursor-pointer select-none" onclick="setSort('status')">
                                        Status <i class="fas fa-sort ml-1 text-gray-400 sort-icon" data-sort-key="status"></i>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider no-print">Diperbarui</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @foreach($forestLands as $index => $land)
                                    <tr class="land-row hover:bg-emerald-50 transition duration-150"
                                        data-id="{{ $land->id }}"
                                        data-name="{{ strtolower($land->nama_lahan) }}"
                                        data-status="{{ $land->status }}"
                                        data-luas="{{ $land->luas_hektar }}">
                                        <td class="px-4 py-4 whitespace-nowrap no-print">
                                            <input type="checkbox" class="row-checkbox w-4 h-4 accent-emerald-600" value="{{ $land->id }}" onchange="updateBulkBar()">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap row-number"><span class="font-bold text-gray-700">{{ $index + 1 }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button type="button" onclick="showLandDetail('{{ $land->id }}')" class="font-semibold text-gray-900 hover:text-emerald-700 hover:underline text-left">{{ $land->nama_lahan }}</button>
                                            <div class="text-[11px] text-gray-400 font-mono">PHT-{{ str_pad($land->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-emerald-700">{{ number_format($land->luas_hektar, 2) }} Ha</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $land->status == 'Produksi' ? 'bg-blue-100 text-blue-800' : ($land->status == 'Konservasi' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $land->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 no-print" data-updated-cell>
                                            {{ isset($land->updated_at) && $land->updated_at ? $land->updated_at->diffForHumans() : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <button type="button" onclick="showLandDetail('{{ $land->id }}')" class="no-print bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-2.5 py-1.5 rounded-md text-xs font-semibold shadow-sm" title="Lihat detail"><i class="fas fa-circle-info"></i></button>
                                                <a href="{{ route('forest.edit', $land->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold shadow-sm" title="Edit lahan"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('forest.destroy', $land->id) }}" method="POST" class="inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)" class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold shadow-sm" title="Hapus lahan"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-search text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-500 font-medium">Tidak ada lahan yang cocok dengan filter Anda.</p>
                        <button onclick="resetFilters()" class="mt-3 text-emerald-600 hover:text-emerald-800 text-sm font-semibold"><i class="fas fa-redo mr-1"></i> Reset filter</button>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-gray-100 bg-gray-50 no-print">
                        <p class="text-sm text-gray-500" id="paginationInfo">Menampilkan data</p>
                        <div class="flex items-center space-x-1" id="paginationControls"></div>
                    </div>
                @else
                    <div class="text-center py-14">
                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-500 mb-4">Belum ada data lahan.</p>
                        <button onclick="switchPage('tambah-lahan')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-md transition inline-flex items-center space-x-2">
                            <i class="fas fa-plus"></i> <span>Tambah Lahan Pertama</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Signature block (print only) -->
            <div class="print-signature">
                <div class="print-signature-col">
                    <p>Mengetahui,</p>
                    <p class="print-signature-role">Kepala Unit Perhutanan</p>
                    <div class="print-signature-line"></div>
                    <p class="print-signature-name">( ____________________ )</p>
                </div>
                <div class="print-signature-col">
                    <p>Dibuat oleh,</p>
                    <p class="print-signature-role">Petugas Pencatat Lahan</p>
                    <div class="print-signature-line"></div>
                    <p class="print-signature-name">( ____________________ )</p>
                </div>
            </div>
        </section>

        <!-- ============ TAMBAH LAHAN PAGE ============ -->
        <section id="page-tambah-lahan" class="page-section hidden space-y-6">
            <div class="flex items-center space-x-3 mb-2">
                <button onclick="switchPage('dashboard')" class="p-2 bg-white rounded-lg shadow border border-gray-200 text-emerald-700 hover:bg-gray-50"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <h2 class="text-3xl font-bold text-emerald-900">Tambah Lahan Baru</h2>
                    <p class="text-gray-600">Daftarkan blok lahan komoditas perhutanan baru ke dalam sistem</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Form utama -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 p-6 sm:p-8">
                    <form method="POST" action="{{ route('forest.store') }}" class="space-y-6" id="addForm" onsubmit="return validateAddForm()">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-signature text-emerald-500 mr-1"></i> Nama Lahan / Blok Hutan
                            </label>
                            <input type="text" name="nama_lahan" id="nama_lahan" required minlength="3"
                                   placeholder="Contoh: Blok RPH Mangunan A1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-base"
                                   oninput="updatePreview()">
                            <p class="text-xs text-gray-400 mt-1.5">Gunakan nama yang jelas agar mudah dikenali pada tabel &amp; grafik.</p>
                            <p id="duplicateWarning" class="hidden text-xs text-amber-600 mt-1.5"><i class="fas fa-triangle-exclamation mr-1"></i> Nama ini mirip dengan lahan yang sudah terdaftar. Pastikan bukan data ganda.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-ruler-combined text-emerald-500 mr-1"></i> Luas Lahan (Hektar)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.01" min="0.01" name="luas_hektar" id="luas_hektar" required
                                           placeholder="0.00"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-base"
                                           oninput="updatePreview()">
                                    <span class="absolute right-4 top-3.5 text-sm text-gray-400 font-bold">Ha</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tag text-emerald-500 mr-1"></i> Status Pemanfaatan
                                </label>
                                <select name="status" id="status" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none text-base"
                                        onchange="updatePreview()">
                                    <option value="Konservasi">Konservasi</option>
                                    <option value="Produksi">Produksi</option>
                                    <option value="Reboisasi">Reboisasi</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pilihan status bergambar, mempermudah & memperjelas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Cepat Status</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <button type="button" onclick="quickStatus('Konservasi')" class="status-quick-btn border-2 border-green-200 hover:border-green-500 bg-green-50 rounded-lg p-3 text-left transition">
                                    <i class="fas fa-leaf text-green-600 text-lg mb-1"></i>
                                    <p class="font-semibold text-green-800 text-sm">Konservasi</p>
                                    <p class="text-xs text-green-600">Perlindungan ekosistem</p>
                                </button>
                                <button type="button" onclick="quickStatus('Produksi')" class="status-quick-btn border-2 border-blue-200 hover:border-blue-500 bg-blue-50 rounded-lg p-3 text-left transition">
                                    <i class="fas fa-industry text-blue-600 text-lg mb-1"></i>
                                    <p class="font-semibold text-blue-800 text-sm">Produksi</p>
                                    <p class="text-xs text-blue-600">Hasil hutan komersial</p>
                                </button>
                                <button type="button" onclick="quickStatus('Reboisasi')" class="status-quick-btn border-2 border-yellow-200 hover:border-yellow-500 bg-yellow-50 rounded-lg p-3 text-left transition">
                                    <i class="fas fa-tree text-yellow-600 text-lg mb-1"></i>
                                    <p class="font-semibold text-yellow-800 text-sm">Reboisasi</p>
                                    <p class="text-xs text-yellow-600">Penanaman kembali</p>
                                </button>
                            </div>
                        </div>

                        <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4 text-xs text-emerald-700 flex items-start space-x-2">
                            <i class="fas fa-circle-info mt-0.5"></i>
                            <span>Data akan langsung tampil pada Dashboard dan grafik Analisis Lahan setelah disimpan.</span>
                        </div>

                        <div class="pt-2 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" onclick="switchPage('dashboard')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-medium transition">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-md transition flex items-center justify-center space-x-2">
                                <i class="fas fa-save"></i> <span>Simpan Data Lahan</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Panel bantuan & pratinjau -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-lg border-t-4 border-teal-500 p-6">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4 flex items-center">
                            <i class="fas fa-eye text-teal-600 mr-2"></i> Pratinjau Data
                        </h4>
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-4 space-y-3">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Nama Lahan</p>
                                <p id="previewNama" class="font-bold text-gray-800 text-lg">-</p>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wide">Luas</p>
                                    <p id="previewLuas" class="font-bold text-emerald-700">0.00 Ha</p>
                                </div>
                                <span id="previewStatus" class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Konservasi</span>
                            </div>
                            <div class="pt-2 border-t border-gray-100">
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Kode Lahan (otomatis)</p>
                                <p id="previewKode" class="font-mono text-sm text-gray-500">PHT-{{ str_pad($forestLands->count() + 1, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500 p-6">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4 flex items-center">
                            <i class="fas fa-lightbulb text-amber-500 mr-2"></i> Tips Pengisian
                        </h4>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Sertakan kode petak/RPH pada nama agar mudah dicari, contoh <em>"RPH Mangunan A1"</em>.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Luas lahan diinput dalam satuan hektar, gunakan titik desimal misal <em>12.50</em>.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Status menentukan warna &amp; pengelompokan lahan pada grafik Analisis.</span>
                            </li>
                            <li class="flex items-start space-x-2">
                                <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                                <span>Sistem akan menandai peringatan jika nama lahan yang dimasukkan mirip dengan data yang sudah ada, untuk mencegah pencatatan ganda.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg border-t-4 border-emerald-500 p-6">
                        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4 flex items-center">
                            <i class="fas fa-chart-simple text-emerald-600 mr-2"></i> Ringkasan Saat Ini
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Lahan</span>
                                <span class="font-bold text-emerald-700">{{ $forestLands->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Luas</span>
                                <span class="font-bold text-emerald-700">{{ number_format($forestLands->sum('luas_hektar'), 2) }} Ha</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ ANALISIS PAGE ============ -->
        <section id="page-analisis" class="page-section hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                <div>
                    <h2 class="text-3xl font-bold text-emerald-900 mb-2">Analisis Visual Data Lahan</h2>
                    <p class="text-gray-600">Distribusi kalkulasi luas lahan terdaftar berdasarkan parameter status wilayah</p>
                </div>
                <button onclick="printPage()" class="no-print bg-white border-2 border-gray-300 text-gray-600 hover:bg-gray-50 px-3 py-2 rounded-lg text-sm font-semibold transition flex items-center space-x-1 self-start">
                    <i class="fas fa-print"></i> <span>Cetak Analisis</span>
                </button>
            </div>

            <!-- Insight otomatis -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center">
                    <i class="fas fa-wand-magic-sparkles text-emerald-600 mr-2"></i> Ringkasan Insight
                </h4>
                <ul id="insightList" class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start space-x-2"><i class="fas fa-circle-notch fa-spin text-gray-300 mt-1"></i><span>Menghitung insight...</span></li>
                </ul>
            </div>

            <!-- Rasio kawasan konservasi vs target kebijakan -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center">
                        <i class="fas fa-shield-halved text-green-600 mr-2"></i> Rasio Kawasan Konservasi
                    </h4>
                    <span class="text-xs text-gray-400">Acuan minimum kebijakan: <b class="text-gray-600">30%</b> dari total luas</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden relative">
                    <div id="conservationBar" class="h-5 rounded-full transition-all duration-700 flex items-center justify-end pr-2" style="width:0%; background-color:#10b981;">
                        <span id="conservationPct" class="text-[10px] font-bold text-white"></span>
                    </div>
                    <div class="absolute top-0 h-5 border-l-2 border-dashed border-gray-400" style="left:30%;"></div>
                </div>
                <p id="conservationNote" class="text-xs text-gray-500 mt-2"></p>
            </div>

            <!-- Rasio produksi vs efisiensi pemanfaatan -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-blue-500">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                    <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center">
                        <i class="fas fa-industry text-blue-600 mr-2"></i> Rasio Lahan Produksi Aktif
                    </h4>
                    <span class="text-xs text-gray-400">Porsi luas yang dimanfaatkan secara komersial</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden relative">
                    <div id="productionBar" class="h-5 rounded-full transition-all duration-700 flex items-center justify-end pr-2" style="width:0%; background-color:#3b82f6;">
                        <span id="productionPct" class="text-[10px] font-bold text-white"></span>
                    </div>
                </div>
                <p id="productionNote" class="text-xs text-gray-500 mt-2"></p>
            </div>

            <!-- Tabel ringkasan detail per status -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center space-x-2">
                        <i class="fas fa-table-list"></i> <span>Ringkasan Detail per Status</span>
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah Lahan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Luas (Ha)</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rata-rata Luas (Ha)</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">% dari Total Luas</th>
                            </tr>
                        </thead>
                        <tbody id="summaryTableBody" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-emerald-900 flex items-center">
                            <i class="fas fa-chart-pie text-emerald-600 mr-2"></i> Proporsi Distribusi Lahan (Ha)
                        </h4>
                        <button onclick="downloadChart('pieChart','proporsi-distribusi-lahan')" class="no-print text-gray-400 hover:text-emerald-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-emerald-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Akumulasi Total: <span id="pieTotal" class="font-bold text-emerald-700">0</span> Ha</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-emerald-900 flex items-center">
                            <i class="fas fa-chart-bar text-green-600 mr-2"></i> Perbandingan Luas Berdasarkan Status
                        </h4>
                        <button onclick="downloadChart('barChart','perbandingan-luas-status')" class="no-print text-gray-400 hover:text-emerald-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-green-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Akumulasi Total: <span id="barTotal" class="font-bold text-green-700">0</span> Ha</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-teal-500">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-emerald-900 flex items-center">
                            <i class="fas fa-list-ol text-teal-600 mr-2"></i> Jumlah Blok Lahan per Status
                        </h4>
                        <button onclick="downloadChart('donutChart','jumlah-blok-per-status')" class="no-print text-gray-400 hover:text-emerald-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="donutChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-teal-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Total Blok: <span id="donutTotal" class="font-bold text-teal-700">0</span> lahan</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-amber-500">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-emerald-900 flex items-center">
                            <i class="fas fa-ranking-star text-amber-600 mr-2"></i> Top 5 Lahan Terluas
                        </h4>
                        <button onclick="downloadChart('topChart','top-5-lahan-terluas')" class="no-print text-gray-400 hover:text-emerald-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="topChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-amber-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Berdasarkan luas hektar tertinggi saat ini</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-blue-500 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-emerald-900 flex items-center">
                            <i class="fas fa-layer-group text-blue-600 mr-2"></i> Distribusi Ukuran Lahan
                        </h4>
                        <button onclick="downloadChart('sizeChart','distribusi-ukuran-lahan')" class="no-print text-gray-400 hover:text-emerald-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 280px;">
                        <canvas id="sizeChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-blue-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Kecil &lt; 10 Ha &nbsp;·&nbsp; Sedang 10–50 Ha &nbsp;·&nbsp; Besar &gt; 50 Ha</p>
                    </div>
                </div>
            </div>

            <!-- Signature block (print only) -->
            <div class="print-signature">
                <div class="print-signature-col">
                    <p>Mengetahui,</p>
                    <p class="print-signature-role">Kepala Unit Perhutanan</p>
                    <div class="print-signature-line"></div>
                    <p class="print-signature-name">( ____________________ )</p>
                </div>
                <div class="print-signature-col">
                    <p>Disusun oleh,</p>
                    <p class="print-signature-role">Analis Data Lahan</p>
                    <div class="print-signature-line"></div>
                    <p class="print-signature-name">( ____________________ )</p>
                </div>
            </div>
        </section>

    </div>

    <!-- ============ TOMBOL KEMBALI KE ATAS ============ -->
    <button id="backToTopBtn" onclick="scrollToTop()" class="hidden no-print fixed bottom-6 right-6 z-40 bg-emerald-600 hover:bg-emerald-700 text-white w-11 h-11 rounded-full shadow-lg flex items-center justify-center transition" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-section:not(.hidden) {
            animation: fade-in 0.4s ease-out forwards;
        }
        .chip-btn.chip-active {
            transform: translateY(-1px);
        }
        #tableBody tr.hidden-row {
            display: none !important;
        }
        .page-num-btn.active-page {
            background-color: #059669;
            color: #fff;
            border-color: #059669;
        }
        .search-highlight {
            background-color: #fef08a;
            border-radius: 2px;
            padding: 0 1px;
        }
        .print-header { display: none; }
        .print-signature { display: none; }
        @media print {
            nav, #mobileMenu, #flashSuccess, #flashError, #liveClock,
            .filter-card, #noResults, #paginationControls, #paginationInfo,
            .delete-form, td:last-child, th:last-child, .sort-icon,
            #searchInput, .relative i.fa-search, .no-print, #backToTopBtn,
            #bulkActionBar {
                display: none !important;
            }

            .print-header { display: block !important; }
            .print-header-inner { display: flex; align-items: center; gap: 14px; padding: 6px 0 10px 0; }
            .print-header-inner i { font-size: 34px; color: #059669; }
            .print-header-text h1 { font-size: 20px; font-weight: 800; color: #065f46; letter-spacing: 0.5px; margin: 0; }
            .print-header-text p { font-size: 12px; color: #374151; margin: 1px 0; }
            .print-header-sub { color: #6b7280 !important; font-size: 10px !important; }
            .print-header hr { border: none; border-top: 2px solid #059669; margin-bottom: 14px; }

            .print-signature { display: flex !important; justify-content: space-between; margin-top: 48px; padding-top: 8px; }
            .print-signature-col { width: 45%; text-align: center; font-size: 12px; color: #111827; }
            .print-signature-role { font-weight: 700; margin: 2px 0 40px 0; }
            .print-signature-line { border-top: 1px solid #111827; margin: 0 10px; }
            .print-signature-name { margin-top: 4px; }

            #statusChips { display: flex !important; }
            .chip-btn { cursor: default !important; box-shadow: none !important; }

            .page-section.hidden { display: none !important; }
            .page-section:not(.hidden) { display: block !important; animation: none !important; }

            body { background: #fff !important; }
            .shadow-lg, .shadow, .shadow-md, .shadow-sm, .shadow-xl { box-shadow: none !important; }

            canvas { max-width: 100% !important; }
        }
    </style>

    <script>
        // ---------- Navigation ----------
        function switchPage(pageId) {
            document.querySelectorAll('.page-section').forEach(section => section.classList.add('hidden'));
            document.getElementById(`page-${pageId}`).classList.remove('hidden');

            const tabs = ['dashboard', 'tambah-lahan', 'analisis'];
            tabs.forEach(tab => {
                const btn = document.getElementById(`tab-${tab}`);
                if (btn) btn.className = "px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 text-gray-600 hover:bg-gray-200";
                const mbtn = document.getElementById(`mtab-${tab}`);
                if (mbtn) mbtn.className = "w-full text-left text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2";
            });

            const activeTab = document.getElementById(`tab-${pageId}`);
            if (activeTab) activeTab.className = "px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 bg-emerald-600 text-white shadow";
            const activeMTab = document.getElementById(`mtab-${pageId}`);
            if (activeMTab) activeMTab.className = "w-full text-left bg-emerald-50 text-emerald-800 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2";

            if (pageId === 'analisis') initCharts(currentFilteredData());
        }

        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) document.getElementById('mobileMenu').classList.add('hidden');
        });

        // ---------- Flash messages ----------
        function dismissFlash(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.transition = 'opacity .3s, transform .3s';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(() => el.remove(), 300);
        }
        ['flashSuccess', 'flashError'].forEach(id => {
            const bar = document.getElementById(id + 'Bar');
            if (bar) {
                let w = 100;
                const t = setInterval(() => {
                    w -= 100 / 50;
                    bar.style.width = Math.max(w, 0) + '%';
                    if (w <= 0) { clearInterval(t); dismissFlash(id); }
                }, 100);
            }
        });

        // ---------- Live clock ----------
        function updateClock() {
            const el = document.getElementById('liveClock');
            if (!el) return;
            const now = new Date();
            el.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) + ' · ' + now.toLocaleTimeString('id-ID');
        }
        updateClock();
        setInterval(updateClock, 1000);

        // ---------- Delete confirmation ----------
        function getCsrfToken() {
            const input = document.querySelector('.delete-form input[name="_token"]');
            return input ? input.value : '';
        }

        function confirmDelete(btn) {
            const form = btn.closest('form');
            Swal.fire({
                title: 'Hapus lahan ini?',
                text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }

        // ---------- Add form: live preview, quick status, duplicate check ----------
        const statusBadgeClass = {
            Konservasi: 'bg-green-100 text-green-800',
            Produksi: 'bg-blue-100 text-blue-800',
            Reboisasi: 'bg-yellow-100 text-yellow-800'
        };

        function updatePreview() {
            const nama = document.getElementById('nama_lahan')?.value.trim();
            const luas = parseFloat(document.getElementById('luas_hektar')?.value);
            const status = document.getElementById('status')?.value || 'Konservasi';

            const previewNama = document.getElementById('previewNama');
            const previewLuas = document.getElementById('previewLuas');
            const previewStatus = document.getElementById('previewStatus');
            if (!previewNama) return;

            previewNama.textContent = nama ? nama : '-';
            previewLuas.textContent = (isNaN(luas) ? 0 : luas).toFixed(2) + ' Ha';
            previewStatus.textContent = status;
            previewStatus.className = `px-3 py-1 rounded-full text-xs font-bold ${statusBadgeClass[status] || statusBadgeClass.Konservasi}`;

            const warning = document.getElementById('duplicateWarning');
            if (warning && typeof landsData !== 'undefined' && nama) {
                const lower = nama.toLowerCase();
                const similar = landsData.some(l => l.nama_lahan.toLowerCase() === lower || (lower.length > 3 && l.nama_lahan.toLowerCase().includes(lower)));
                warning.classList.toggle('hidden', !similar);
            }
        }

        function quickStatus(status) {
            const select = document.getElementById('status');
            if (select) select.value = status;
            document.querySelectorAll('.status-quick-btn').forEach(b => b.classList.remove('ring-2', 'ring-offset-1'));
            const map = { Konservasi: 'ring-green-500', Produksi: 'ring-blue-500', Reboisasi: 'ring-yellow-500' };
            event?.currentTarget?.classList.add('ring-2', 'ring-offset-1', map[status]);
            updatePreview();
        }

        // ---------- Add form validation ----------
        function validateAddForm() {
            const luas = parseFloat(document.getElementById('luas_hektar').value);
            if (isNaN(luas) || luas <= 0) {
                Swal.fire('Luas tidak valid', 'Masukkan luas lahan lebih besar dari 0 hektar.', 'error');
                return false;
            }
            return true;
        }

        // ---------- Data / Filter / Sort / Pagination ----------
        const landsData = @json($forestLands);
        let chipFilter = 'all';
        let sortKey = null;
        let sortDir = 'asc';
        let currentPage = 1;

        function currentFilteredData() {
            const searchTerm = (document.getElementById('searchInput')?.value || '').toLowerCase();
            const statusFilter = document.getElementById('statusFilter')?.value || 'all';
            const sizeFilter = document.getElementById('sizeFilter')?.value || 'all';

            let data = landsData.filter(land => {
                const matchSearch = land.nama_lahan.toLowerCase().includes(searchTerm);
                const effectiveStatus = chipFilter !== 'all' ? chipFilter : statusFilter;
                const matchStatus = effectiveStatus === 'all' || land.status === effectiveStatus;
                const luas = parseFloat(land.luas_hektar);
                let matchSize = true;
                if (sizeFilter === 'small') matchSize = luas < 10;
                else if (sizeFilter === 'medium') matchSize = luas >= 10 && luas <= 50;
                else if (sizeFilter === 'large') matchSize = luas > 50;
                return matchSearch && matchStatus && matchSize;
            });

            if (sortKey) {
                data = [...data].sort((a, b) => {
                    let va = a[sortKey], vb = b[sortKey];
                    if (sortKey === 'luas_hektar') { va = parseFloat(va); vb = parseFloat(vb); }
                    else { va = String(va).toLowerCase(); vb = String(vb).toLowerCase(); }
                    if (va < vb) return sortDir === 'asc' ? -1 : 1;
                    if (va > vb) return sortDir === 'asc' ? 1 : -1;
                    return 0;
                });
            }
            return data;
        }

        function setChipFilter(status) {
            chipFilter = status;
            document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('chip-active'));
            document.querySelector(`.chip-btn[data-chip="${status}"]`)?.classList.add('chip-active');
            if (status !== 'all') document.getElementById('statusFilter').value = 'all';
            currentPage = 1;
            applyFilters();
        }

        function setSort(key) {
            if (sortKey === key) sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            else { sortKey = key; sortDir = 'asc'; }
            document.querySelectorAll('.sort-icon').forEach(icon => icon.className = 'fas fa-sort ml-1 text-gray-400 sort-icon');
            const activeIcon = document.querySelector(`.sort-icon[data-sort-key="${key}"]`);
            if (activeIcon) activeIcon.className = `fas fa-sort-${sortDir === 'asc' ? 'up' : 'down'} ml-1 text-emerald-600 sort-icon`;
            currentPage = 1;
            applyFilters();
        }

        function highlightSearchTerm() {
            const term = (document.getElementById('searchInput')?.value || '').trim();
            document.querySelectorAll('#tableBody .land-row:not(.hidden-row) button[onclick^="showLandDetail"]').forEach(btn => {
                const original = btn.dataset.original || btn.textContent;
                btn.dataset.original = original;
                if (!term) { btn.textContent = original; return; }
                const idx = original.toLowerCase().indexOf(term.toLowerCase());
                if (idx === -1) { btn.textContent = original; return; }
                const before = original.slice(0, idx);
                const match = original.slice(idx, idx + term.length);
                const after = original.slice(idx + term.length);
                btn.innerHTML = `${before}<span class="search-highlight">${match}</span>${after}`;
            });
        }

        function applyFilters() {
            const tableBody = document.getElementById('tableBody');
            if (!tableBody) return;
            const rows = Array.from(document.querySelectorAll('.land-row'));
            const rowById = {};
            rows.forEach(r => rowById[r.dataset.id] = r);

            const filtered = currentFilteredData();
            const perPage = parseInt(document.getElementById('perPage')?.value || '10', 10);
            const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
            if (currentPage > totalPages) currentPage = totalPages;
            const start = (currentPage - 1) * perPage;
            const pageItems = filtered.slice(start, start + perPage);

            rows.forEach(r => r.classList.add('hidden-row'));

            pageItems.forEach((land, i) => {
                const row = rowById[land.id];
                if (!row) return;
                row.classList.remove('hidden-row');
                tableBody.appendChild(row);
                const numCell = row.querySelector('.row-number span');
                if (numCell) numCell.textContent = start + i + 1;
            });

            const noResults = document.getElementById('noResults');
            if (noResults) noResults.classList.toggle('hidden', filtered.length > 0);

            const infoEl = document.getElementById('paginationInfo');
            if (infoEl) {
                if (filtered.length === 0) infoEl.textContent = 'Tidak ada data untuk ditampilkan';
                else infoEl.textContent = `Menampilkan ${start + 1}-${Math.min(start + pageItems.length, filtered.length)} dari ${filtered.length} data`;
            }

            renderPagination(totalPages);
            highlightSearchTerm();
            updateBulkBar();
        }

        function renderPagination(totalPages) {
            const controls = document.getElementById('paginationControls');
            if (!controls) return;
            controls.innerHTML = '';
            if (totalPages <= 1) return;

            const makeBtn = (label, page, disabled = false, active = false) => {
                const btn = document.createElement('button');
                btn.textContent = label;
                btn.className = `page-num-btn px-3 py-1.5 text-sm rounded-lg border transition ${active ? 'active-page' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100'} ${disabled ? 'opacity-40 cursor-not-allowed' : ''}`;
                if (!disabled) btn.onclick = () => { currentPage = page; applyFilters(); };
                return btn;
            };

            controls.appendChild(makeBtn('«', currentPage - 1, currentPage === 1));
            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && p !== 1 && p !== totalPages && Math.abs(p - currentPage) > 1) {
                    if (p === 2 || p === totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '…';
                        dots.className = 'px-2 text-gray-400';
                        controls.appendChild(dots);
                    }
                    continue;
                }
                controls.appendChild(makeBtn(String(p), p, false, p === currentPage));
            }
            controls.appendChild(makeBtn('»', currentPage + 1, currentPage === totalPages));
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('sizeFilter').value = 'all';
            document.getElementById('perPage').value = '10';
            chipFilter = 'all';
            sortKey = null;
            document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('chip-active'));
            document.querySelector('.chip-btn[data-chip="all"]')?.classList.add('chip-active');
            document.querySelectorAll('.sort-icon').forEach(icon => icon.className = 'fas fa-sort ml-1 text-gray-400 sort-icon');
            currentPage = 1;
            applyFilters();
        }

        // ---------- Bulk selection ----------
        function toggleSelectAll(checkbox) {
            document.querySelectorAll('#tableBody .land-row:not(.hidden-row) .row-checkbox').forEach(cb => cb.checked = checkbox.checked);
            updateBulkBar();
        }

        function updateBulkBar() {
            const checked = Array.from(document.querySelectorAll('.row-checkbox')).filter(cb => cb.checked);
            const bar = document.getElementById('bulkActionBar');
            const count = document.getElementById('bulkCount');
            if (!bar || !count) return;
            count.textContent = checked.length;
            bar.classList.toggle('hidden', checked.length === 0);
            bar.classList.toggle('flex', checked.length > 0);
        }

        function clearSelection() {
            document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
            const selectAll = document.getElementById('selectAllRows');
            if (selectAll) selectAll.checked = false;
            updateBulkBar();
        }

        function getSelectedIds() {
            return Array.from(document.querySelectorAll('.row-checkbox')).filter(cb => cb.checked).map(cb => cb.value);
        }

        function bulkExportSelected() {
            const ids = getSelectedIds();
            const data = landsData.filter(l => ids.includes(String(l.id)));
            if (data.length === 0) return;
            let csv = 'Nama Lahan,Luas (Ha),Status\n';
            data.forEach(l => { csv += `"${l.nama_lahan.replace(/"/g, '""')}",${l.luas_hektar},${l.status}\n`; });
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `lahan-terpilih-${new Date().toISOString().slice(0, 10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        function bulkDeleteSelected() {
            const ids = getSelectedIds();
            if (ids.length === 0) return;
            Swal.fire({
                title: `Hapus ${ids.length} lahan terpilih?`,
                text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus semua',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (!result.isConfirmed) return;
                const token = getCsrfToken();
                try {
                    await Promise.all(ids.map(id => {
                        const form = document.querySelector(`.land-row[data-id="${id}"] .delete-form`);
                        const action = form ? form.getAttribute('action') : null;
                        if (!action) return Promise.resolve();
                        const body = new FormData();
                        body.append('_token', token);
                        body.append('_method', 'DELETE');
                        return fetch(action, { method: 'POST', body, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    }));
                    location.reload();
                } catch (e) {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus data terpilih.', 'error');
                }
            });
        }

        // ---------- Detail lahan (modal) ----------
        function showLandDetail(id) {
            const land = landsData.find(l => String(l.id) === String(id));
            if (!land) return;
            const badge = statusBadgeClass[land.status] || statusBadgeClass.Konservasi;
            const kode = 'PHT-' + String(land.id).padStart(4, '0');
            const updated = land.updated_at ? timeAgo(land.updated_at) : '-';
            const created = land.created_at ? timeAgo(land.created_at) : '-';
            Swal.fire({
                title: land.nama_lahan,
                html: `
                    <div style="text-align:left; font-size:13px; line-height:1.9;">
                        <p><b>Kode Lahan:</b> <span style="font-family:monospace;">${kode}</span></p>
                        <p><b>Luas:</b> ${parseFloat(land.luas_hektar).toFixed(2)} Ha</p>
                        <p><b>Status:</b> <span class="${badge}" style="padding:2px 10px; border-radius:999px; font-weight:700; font-size:11px;">${land.status}</span></p>
                        <p><b>Dicatat:</b> ${created}</p>
                        <p><b>Diperbarui:</b> ${updated}</p>
                    </div>
                `,
                confirmButtonColor: '#059669',
                confirmButtonText: 'Tutup'
            });
        }

        // ---------- Waktu relatif sederhana ----------
        function timeAgo(dateStr) {
            if (!dateStr) return '-';
            const then = new Date(dateStr.replace(' ', 'T'));
            if (isNaN(then.getTime())) return dateStr;
            const diffSec = Math.floor((Date.now() - then.getTime()) / 1000);
            if (diffSec < 60) return 'Baru saja';
            const diffMin = Math.floor(diffSec / 60);
            if (diffMin < 60) return `${diffMin} menit lalu`;
            const diffHour = Math.floor(diffMin / 60);
            if (diffHour < 24) return `${diffHour} jam lalu`;
            const diffDay = Math.floor(diffHour / 24);
            if (diffDay < 30) return `${diffDay} hari lalu`;
            return then.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        }

        // ---------- Aktivitas terbaru & catatan pengawasan ----------
        function renderRecentActivity() {
            const list = document.getElementById('recentActivityList');
            if (!list) return;
            const withDates = landsData.filter(l => l.updated_at || l.created_at);
            if (withDates.length === 0) {
                list.innerHTML = `<li class="py-3 text-sm text-gray-400">Belum ada riwayat pembaruan yang tercatat.</li>`;
                return;
            }
            const sorted = [...withDates].sort((a, b) => new Date((b.updated_at || b.created_at).replace(' ', 'T')) - new Date((a.updated_at || a.created_at).replace(' ', 'T')));
            const badge = { Konservasi: 'bg-green-100 text-green-800', Produksi: 'bg-blue-100 text-blue-800', Reboisasi: 'bg-yellow-100 text-yellow-800' };
            list.innerHTML = sorted.slice(0, 5).map(l => `
                <li class="py-3 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-800 text-sm truncate">${l.nama_lahan}</p>
                        <p class="text-xs text-gray-400">${timeAgo(l.updated_at || l.created_at)}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold shrink-0 ${badge[l.status] || badge.Konservasi}">${l.status}</span>
                </li>
            `).join('');
        }

        function renderWatchNotes() {
            const list = document.getElementById('watchNotesList');
            if (!list) return;
            const notes = [];
            if (landsData.length === 0) {
                notes.push({ icon: 'fa-circle-info', color: 'text-gray-400', text: 'Belum ada data lahan untuk dipantau.' });
            } else {
                const tiny = landsData.filter(l => parseFloat(l.luas_hektar) < 1);
                if (tiny.length > 0) {
                    notes.push({ icon: 'fa-magnifying-glass', color: 'text-amber-500', text: `${tiny.length} lahan tercatat dengan luas di bawah 1 Ha, perlu verifikasi ulang di lapangan.` });
                }
                const names = landsData.map(l => l.nama_lahan.trim().toLowerCase());
                const dupes = names.filter((n, i) => names.indexOf(n) !== i);
                if (dupes.length > 0) {
                    notes.push({ icon: 'fa-copy', color: 'text-red-500', text: 'Terdeteksi kemungkinan nama lahan ganda pada data terdaftar.' });
                }
                const totalLuas = landsData.reduce((s, l) => s + parseFloat(l.luas_hektar), 0);
                const konservasiLuas = landsData.filter(l => l.status === 'Konservasi').reduce((s, l) => s + parseFloat(l.luas_hektar), 0);
                const konservasiPct = totalLuas > 0 ? (konservasiLuas / totalLuas) * 100 : 0;
                if (konservasiPct < 30) {
                    notes.push({ icon: 'fa-shield-halved', color: 'text-amber-500', text: `Kawasan konservasi baru ${konservasiPct.toFixed(1)}% dari total luas, di bawah acuan minimum kebijakan 30%.` });
                } else {
                    notes.push({ icon: 'fa-circle-check', color: 'text-green-600', text: `Kawasan konservasi telah memenuhi acuan minimum kebijakan (${konservasiPct.toFixed(1)}%).` });
                }
                if (notes.length === 0) notes.push({ icon: 'fa-circle-check', color: 'text-green-600', text: 'Tidak ada catatan khusus. Data lahan terpantau baik.' });
            }
            list.innerHTML = notes.map(n => `<li class="flex items-start space-x-2"><i class="fas ${n.icon} ${n.color} mt-0.5"></i><span>${n.text}</span></li>`).join('');
        }

        // ---------- Print ----------
        function printPage() {
            const dateEl = document.getElementById('printDate');
            if (dateEl) dateEl.textContent = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) + ' pukul ' + new Date().toLocaleTimeString('id-ID');
            // Jika halaman analisis sedang aktif, pastikan chart sudah ter-render ulang
            // agar ukurannya pas sebelum dicetak (chart.js perlu sedikit delay setelah resize/layout).
            const analisisVisible = !document.getElementById('page-analisis').classList.contains('hidden');
            if (analisisVisible) {
                initCharts(landsData);
                setTimeout(() => window.print(), 300);
            } else {
                window.print();
            }
        }

        // ---------- Export CSV ----------
        function exportCSV() {
            const data = currentFilteredData();
            if (data.length === 0) {
                Swal.fire('Tidak ada data', 'Tidak ada data untuk diekspor sesuai filter saat ini.', 'info');
                return;
            }
            let csv = 'Nama Lahan,Luas (Ha),Status\n';
            data.forEach(l => {
                csv += `"${l.nama_lahan.replace(/"/g, '""')}",${l.luas_hektar},${l.status}\n`;
            });
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `data-lahan-${new Date().toISOString().slice(0, 10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // ---------- Charts ----------
        let pieChart, barChart, donutChart, topChart, sizeChart;

        function initCharts(data) {
            const statusLuas = { Konservasi: 0, Produksi: 0, Reboisasi: 0 };
            const statusCount = { Konservasi: 0, Produksi: 0, Reboisasi: 0 };

            landsData.forEach(land => {
                if (statusLuas[land.status] !== undefined) {
                    statusLuas[land.status] += parseFloat(land.luas_hektar);
                    statusCount[land.status] += 1;
                }
            });

            const totalLuas = statusLuas.Konservasi + statusLuas.Produksi + statusLuas.Reboisasi;
            const totalCount = statusCount.Konservasi + statusCount.Produksi + statusCount.Reboisasi;

            if (document.getElementById('pieTotal')) document.getElementById('pieTotal').textContent = totalLuas.toFixed(2);
            if (document.getElementById('barTotal')) document.getElementById('barTotal').textContent = totalLuas.toFixed(2);
            if (document.getElementById('donutTotal')) document.getElementById('donutTotal').textContent = totalCount;

            const palette = ['#10b981', '#3b82f6', '#f59e0b'];

            const pieCtx = document.getElementById('pieChart').getContext('2d');
            if (pieChart) pieChart.destroy();
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{ data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi], backgroundColor: palette, borderWidth: 2, borderColor: '#fff' }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            const barCtx = document.getElementById('barChart').getContext('2d');
            if (barChart) barChart.destroy();
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{ label: 'Total Luas (Ha)', data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi], backgroundColor: palette, borderRadius: 6 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            });

            const donutCtx = document.getElementById('donutChart').getContext('2d');
            if (donutChart) donutChart.destroy();
            donutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{ data: [statusCount.Konservasi, statusCount.Produksi, statusCount.Reboisasi], backgroundColor: palette, borderWidth: 2, borderColor: '#fff' }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, cutout: '60%' }
            });

            const topFive = [...landsData]
                .sort((a, b) => parseFloat(b.luas_hektar) - parseFloat(a.luas_hektar))
                .slice(0, 5);
            const topCtx = document.getElementById('topChart').getContext('2d');
            if (topChart) topChart.destroy();
            topChart = new Chart(topCtx, {
                type: 'bar',
                data: {
                    labels: topFive.map(l => l.nama_lahan),
                    datasets: [{ label: 'Luas (Ha)', data: topFive.map(l => parseFloat(l.luas_hektar)), backgroundColor: '#f59e0b', borderRadius: 6 }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true } }
                }
            });

            // Distribusi ukuran lahan (kecil / sedang / besar)
            const sizeBuckets = { Kecil: 0, Sedang: 0, Besar: 0 };
            landsData.forEach(l => {
                const luas = parseFloat(l.luas_hektar);
                if (luas < 10) sizeBuckets.Kecil++;
                else if (luas <= 50) sizeBuckets.Sedang++;
                else sizeBuckets.Besar++;
            });
            const sizeCtx = document.getElementById('sizeChart').getContext('2d');
            if (sizeChart) sizeChart.destroy();
            sizeChart = new Chart(sizeCtx, {
                type: 'bar',
                data: {
                    labels: ['Kecil (< 10 Ha)', 'Sedang (10-50 Ha)', 'Besar (> 50 Ha)'],
                    datasets: [{ label: 'Jumlah Lahan', data: [sizeBuckets.Kecil, sizeBuckets.Sedang, sizeBuckets.Besar], backgroundColor: ['#93c5fd', '#3b82f6', '#1d4ed8'], borderRadius: 6 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
            });

            renderSummaryTable(statusLuas, statusCount, totalLuas);
            renderConservationRatio(statusLuas, totalLuas);
            renderProductionRatio(statusLuas, totalLuas);
            renderInsights(statusLuas, statusCount, totalLuas, totalCount);
        }

        // ---------- Tabel ringkasan detail per status ----------
        function renderSummaryTable(statusLuas, statusCount, totalLuas) {
            const body = document.getElementById('summaryTableBody');
            if (!body) return;
            const badgeClass = { Konservasi: 'bg-green-100 text-green-800', Produksi: 'bg-blue-100 text-blue-800', Reboisasi: 'bg-yellow-100 text-yellow-800' };
            body.innerHTML = '';
            ['Konservasi', 'Produksi', 'Reboisasi'].forEach(status => {
                const jumlah = statusCount[status] || 0;
                const luas = statusLuas[status] || 0;
                const rata = jumlah > 0 ? luas / jumlah : 0;
                const pct = totalLuas > 0 ? (luas / totalLuas) * 100 : 0;
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 transition';
                tr.innerHTML = `
                    <td class="px-6 py-3 whitespace-nowrap"><span class="px-3 py-1 rounded-full text-xs font-bold ${badgeClass[status]}">${status}</span></td>
                    <td class="px-6 py-3 whitespace-nowrap font-semibold text-gray-700">${jumlah}</td>
                    <td class="px-6 py-3 whitespace-nowrap font-bold text-emerald-700">${luas.toFixed(2)}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-600">${rata.toFixed(2)}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-600">${pct.toFixed(1)}%</td>
                `;
                body.appendChild(tr);
            });
        }

        // ---------- Rasio kawasan konservasi vs target kebijakan ----------
        function renderConservationRatio(statusLuas, totalLuas) {
            const bar = document.getElementById('conservationBar');
            const pctLabel = document.getElementById('conservationPct');
            const note = document.getElementById('conservationNote');
            if (!bar) return;
            const target = 30;
            const pct = totalLuas > 0 ? (statusLuas.Konservasi / totalLuas) * 100 : 0;
            const width = Math.min(pct, 100);
            bar.style.width = width + '%';
            bar.style.backgroundColor = pct >= target ? '#10b981' : '#f59e0b';
            pctLabel.textContent = pct.toFixed(1) + '%';
            if (totalLuas === 0) {
                note.textContent = 'Belum ada data lahan untuk dihitung.';
            } else if (pct >= target) {
                note.innerHTML = `<i class="fas fa-circle-check text-green-600 mr-1"></i> Kawasan konservasi sudah memenuhi acuan minimum ${target}%.`;
            } else {
                const kurang = (target - pct) / 100 * totalLuas;
                note.innerHTML = `<i class="fas fa-triangle-exclamation text-amber-500 mr-1"></i> Masih kurang sekitar <b>${kurang.toFixed(2)} Ha</b> untuk mencapai acuan minimum ${target}%.`;
            }
        }

        // ---------- Rasio lahan produksi aktif ----------
        function renderProductionRatio(statusLuas, totalLuas) {
            const bar = document.getElementById('productionBar');
            const pctLabel = document.getElementById('productionPct');
            const note = document.getElementById('productionNote');
            if (!bar) return;
            const pct = totalLuas > 0 ? (statusLuas.Produksi / totalLuas) * 100 : 0;
            bar.style.width = Math.min(pct, 100) + '%';
            pctLabel.textContent = pct.toFixed(1) + '%';
            if (totalLuas === 0) {
                note.textContent = 'Belum ada data lahan untuk dihitung.';
            } else {
                note.innerHTML = `<i class="fas fa-circle-info text-blue-500 mr-1"></i> <b>${statusLuas.Produksi.toFixed(2)} Ha</b> dari total ${totalLuas.toFixed(2)} Ha lahan berstatus produksi aktif.`;
            }
        }

        // ---------- Insight otomatis ----------
        function renderInsights(statusLuas, statusCount, totalLuas, totalCount) {
            const list = document.getElementById('insightList');
            if (!list) return;
            list.innerHTML = '';
            const addInsight = (icon, color, text) => {
                const li = document.createElement('li');
                li.className = 'flex items-start space-x-2';
                li.innerHTML = `<i class="fas ${icon} ${color} mt-1"></i><span>${text}</span>`;
                list.appendChild(li);
            };

            if (totalCount === 0) {
                addInsight('fa-circle-info', 'text-gray-400', 'Belum ada data lahan yang bisa dianalisis. Tambahkan data lahan terlebih dahulu.');
                return;
            }

            const dominantByLuas = Object.entries(statusLuas).sort((a, b) => b[1] - a[1])[0];
            const dominantPct = totalLuas > 0 ? (dominantByLuas[1] / totalLuas) * 100 : 0;
            addInsight('fa-chart-pie', 'text-emerald-600', `Status <b>${dominantByLuas[0]}</b> mendominasi dengan <b>${dominantPct.toFixed(1)}%</b> dari total luas lahan (${dominantByLuas[1].toFixed(2)} Ha).`);

            const sorted = [...landsData].sort((a, b) => parseFloat(b.luas_hektar) - parseFloat(a.luas_hektar));
            const largest = sorted[0];
            const smallest = sorted[sorted.length - 1];
            addInsight('fa-ranking-star', 'text-amber-500', `Lahan terluas adalah <b>${largest.nama_lahan}</b> (${parseFloat(largest.luas_hektar).toFixed(2)} Ha), sedangkan terkecil <b>${smallest.nama_lahan}</b> (${parseFloat(smallest.luas_hektar).toFixed(2)} Ha).`);

            const avg = totalLuas / totalCount;
            addInsight('fa-balance-scale', 'text-teal-600', `Rata-rata luas per lahan saat ini adalah <b>${avg.toFixed(2)} Ha</b> dari total ${totalCount} blok terdaftar.`);

            const konservasiPct = totalLuas > 0 ? (statusLuas.Konservasi / totalLuas) * 100 : 0;
            if (konservasiPct < 30) {
                addInsight('fa-triangle-exclamation', 'text-amber-500', `Proporsi kawasan konservasi baru <b>${konservasiPct.toFixed(1)}%</b>, masih di bawah acuan minimum kebijakan sebesar 30%.`);
            } else {
                addInsight('fa-circle-check', 'text-green-600', `Proporsi kawasan konservasi <b>${konservasiPct.toFixed(1)}%</b> sudah memenuhi acuan minimum kebijakan sebesar 30%.`);
            }

            const tinyLands = landsData.filter(l => parseFloat(l.luas_hektar) < 1).length;
            if (tinyLands > 0) {
                addInsight('fa-magnifying-glass', 'text-red-500', `Ditemukan <b>${tinyLands} lahan</b> dengan luas di bawah 1 Ha. Disarankan untuk melakukan verifikasi ulang pengukuran di lapangan.`);
            }
        }

        // ---------- Download grafik sebagai gambar ----------
        function downloadChart(canvasId, filename) {
            const chartMap = { pieChart, barChart, donutChart, topChart, sizeChart };
            const chartInstance = chartMap[canvasId];
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const url = chartInstance ? chartInstance.toBase64Image() : canvas.toDataURL('image/png');
            const a = document.createElement('a');
            a.href = url;
            a.download = `${filename}.png`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        // ---------- Kembali ke atas ----------
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        window.addEventListener('scroll', () => {
            const btn = document.getElementById('backToTopBtn');
            if (!btn) return;
            btn.classList.toggle('hidden', window.scrollY < 300);
        });

        // ---------- Wiring ----------
        document.getElementById('searchInput')?.addEventListener('input', () => { currentPage = 1; applyFilters(); });
        document.getElementById('statusFilter')?.addEventListener('change', () => { chipFilter = 'all'; document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('chip-active')); document.querySelector('.chip-btn[data-chip="all"]')?.classList.add('chip-active'); currentPage = 1; applyFilters(); });
        document.getElementById('sizeFilter')?.addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('perPage')?.addEventListener('change', () => { currentPage = 1; applyFilters(); });

        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
                e.preventDefault();
                document.getElementById('searchInput')?.focus();
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.chip-btn[data-chip="all"]')?.classList.add('chip-active');
            applyFilters();
            initCharts(landsData);
            renderRecentActivity();
            renderWatchNotes();
        });
    </script>
</body>
</html>