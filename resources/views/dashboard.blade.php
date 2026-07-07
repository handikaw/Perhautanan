<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perhutani &middot; Buku Catatan Manajemen Lahan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        /* Tema hijau menyeluruh: canopy = hijau utama, bark = hijau moss (pengganti coklat),
                           resin = hijau lime/aksen (pengganti emas), clay = merah dipertahankan khusus
                           untuk aksi bahaya/hapus & error demi kejelasan UX (konvensi universal). */
                        canopy: { 50:'#eef2ed', 100:'#d8e3d7', 300:'#7ea888', 500:'#3f7a5c', 600:'#2f6349', 700:'#234d38', 800:'#1f4d3d', 900:'#152e24' },
                        bark:   { 100:'#e7f0e3', 300:'#a9cba0', 500:'#5e8f57', 600:'#4a7343', 700:'#385a33' },
                        resin:  { 100:'#eef5da', 300:'#bfdc7e', 500:'#8bae35', 600:'#6f8f28', 700:'#556e1e' },
                        clay:   { 100:'#f3ded6', 500:'#b3462c', 600:'#93381f' },
                        mist:   '#f1f4f0',
                        ink:    '#1c2621'
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-mist min-h-screen font-body text-ink">

    <!-- ============ NAVBAR ============ -->
    <nav class="bg-canopy-900 shadow-lg sticky top-0 z-50 border-b-4 border-resin-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3 cursor-pointer group" onclick="switchPage('dashboard')">
                    <div class="bg-resin-500 group-hover:bg-resin-600 transition p-2 rounded-md">
                        <i class="fas fa-tree text-canopy-900 text-xl"></i>
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-xl font-display font-semibold text-white tracking-wide">Perhutani</h1>
                        <p class="text-[11px] text-canopy-100 tracking-widest uppercase">Buku Catatan Lahan &amp; Hasil Hutan</p>
                    </div>
                </div>

                <div class="hidden lg:flex space-x-1 bg-canopy-800/60 p-1 rounded-lg">
                    <button id="tab-dashboard" onclick="switchPage('dashboard')" class="nav-tab-btn"><i class="fas fa-house"></i><span>Dashboard</span></button>
                    <button id="tab-tambah-lahan" onclick="switchPage('tambah-lahan')" class="nav-tab-btn"><i class="fas fa-plus"></i><span>Tambah Lahan</span></button>
                    <button id="tab-kegiatan" onclick="switchPage('kegiatan')" class="nav-tab-btn"><i class="fas fa-clipboard-list"></i><span>Kegiatan Lahan</span></button>
                    <button id="tab-produksi" onclick="switchPage('produksi')" class="nav-tab-btn"><i class="fas fa-hive"></i><span>Produksi Hutan</span></button>
                    <button id="tab-analisis" onclick="switchPage('analisis')" class="nav-tab-btn"><i class="fas fa-chart-pie"></i><span>Analisis</span></button>
                </div>

                <button id="mobileMenuBtn" class="lg:hidden p-2 rounded-md text-canopy-50 hover:bg-canopy-800 transition" onclick="toggleMobileMenu()" aria-label="Buka menu" aria-expanded="false" aria-controls="mobileMenu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="hidden lg:flex items-center space-x-4">
                    <div class="flex items-center space-x-3 text-canopy-50">
                        @if(Auth::check() && Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-9 w-9 rounded-full object-cover border-2 border-resin-400">
                        @else
                            <i class="fas fa-user-circle text-3xl text-canopy-100"></i>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-white">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</span>
                            <a href="{{ route('profile.edit') }}" class="text-xs text-resin-300 hover:text-resin-100 transition">Edit Profil</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-clay-500 hover:bg-clay-600 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center space-x-2">
                            <i class="fas fa-right-from-bracket"></i><span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- ============ MOBILE MENU ============ -->
    <div id="mobileMenu" class="hidden lg:hidden bg-canopy-900 border-b-2 border-resin-500">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
            <button id="mtab-dashboard" onclick="switchPage('dashboard'); toggleMobileMenu();" class="mnav-tab-btn"><i class="fas fa-house w-5"></i><span>Dashboard Utama</span></button>
            <button id="mtab-tambah-lahan" onclick="switchPage('tambah-lahan'); toggleMobileMenu();" class="mnav-tab-btn"><i class="fas fa-plus w-5"></i><span>Tambah Lahan</span></button>
            <button id="mtab-kegiatan" onclick="switchPage('kegiatan'); toggleMobileMenu();" class="mnav-tab-btn"><i class="fas fa-clipboard-list w-5"></i><span>Kegiatan Lahan</span></button>
            <button id="mtab-produksi" onclick="switchPage('produksi'); toggleMobileMenu();" class="mnav-tab-btn"><i class="fas fa-hive w-5"></i><span>Produksi Hutan</span></button>
            <button id="mtab-analisis" onclick="switchPage('analisis'); toggleMobileMenu();" class="mnav-tab-btn"><i class="fas fa-chart-pie w-5"></i><span>Analisis Lahan</span></button>

            <div class="border-t border-canopy-700 pt-3 mt-2">
                <div class="flex items-center space-x-3 px-4 py-2">
                    @if(Auth::check() && Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-11 w-11 rounded-full object-cover border-2 border-resin-400">
                    @else
                        <i class="fas fa-user-circle text-4xl text-canopy-100"></i>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-medium text-white">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</span>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-resin-300">Edit Profil</a>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="border-t border-canopy-700 pt-2">
                @csrf
                <button type="submit" class="block w-full bg-clay-500 hover:bg-clay-600 text-white px-4 py-2.5 rounded-md font-medium text-center">
                    <i class="fas fa-right-from-bracket mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- ============ FLASH MESSAGES ============ -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 space-y-3">
        @if(session('success'))
            <div id="flashSuccess" class="relative overflow-hidden bg-canopy-50 border-l-4 border-canopy-600 text-canopy-800 p-4 rounded-md shadow-md flex items-start space-x-3" role="status">
                <i class="fas fa-circle-check text-2xl mt-1"></i>
                <div><p class="font-semibold">Berhasil!</p><p class="text-sm">{{ session('success') }}</p></div>
                <button onclick="dismissFlash('flashSuccess')" class="ml-auto text-canopy-700 hover:text-canopy-900" aria-label="Tutup notifikasi"><i class="fas fa-times"></i></button>
                <div class="absolute bottom-0 left-0 h-1 bg-canopy-600" id="flashSuccessBar" style="width:100%"></div>
            </div>
        @endif
        @if(session('error'))
            <div id="flashError" class="relative overflow-hidden bg-clay-100 border-l-4 border-clay-500 text-clay-600 p-4 rounded-md shadow-md flex items-start space-x-3" role="alert">
                <i class="fas fa-triangle-exclamation text-2xl mt-1"></i>
                <div><p class="font-semibold">Terjadi Kesalahan</p><p class="text-sm">{{ session('error') }}</p></div>
                <button onclick="dismissFlash('flashError')" class="ml-auto text-clay-600 hover:text-clay-700" aria-label="Tutup notifikasi"><i class="fas fa-times"></i></button>
                <div class="absolute bottom-0 left-0 h-1 bg-clay-500" id="flashErrorBar" style="width:100%"></div>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- ============ DASHBOARD PAGE ============ -->
        <section id="page-dashboard" class="page-section space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 border-b border-canopy-100 pb-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-resin-600 font-semibold mb-1">Ikhtisar Kawasan</p>
                    <h2 class="text-3xl font-display font-semibold text-canopy-900">Dashboard Lahan Perhutanan</h2>
                    <p class="text-gray-600 mt-1">Kelola dan pantau data lahan, kegiatan, serta hasil hutan secara terpadu</p>
                </div>
                <div class="text-sm text-canopy-700 flex items-center space-x-2 bg-white px-3 py-2 rounded-md shadow-sm border border-canopy-100">
                    <i class="fas fa-clock text-resin-500"></i>
                    <span id="liveClock" class="font-mono">-</span>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                <div class="stat-card border-canopy-600">
                    <p class="stat-label">Total Lahan</p>
                    <p class="stat-value text-canopy-800">{{ $forestLands->count() }}</p>
                    <p class="stat-sub">blok terdaftar</p>
                </div>
                <div class="stat-card border-canopy-500">
                    <p class="stat-label">Total Luas</p>
                    <p class="stat-value text-canopy-700">{{ number_format($forestLands->sum('luas_hektar'), 1) }}</p>
                    <p class="stat-sub">hektar (Ha)</p>
                </div>
                <div class="stat-card border-bark-500">
                    <p class="stat-label">Rata-rata Luas</p>
                    <p class="stat-value text-bark-600">{{ $forestLands->count() > 0 ? number_format($forestLands->avg('luas_hektar'), 1) : '0.0' }}</p>
                    <p class="stat-sub">Ha / lahan</p>
                </div>
                <div class="stat-card border-resin-500">
                    <p class="stat-label">Status Dominan</p>
                    <p class="stat-value text-resin-600 text-2xl">{{ $forestLands->count() > 0 ? $forestLands->countBy('status')->sortDesc()->keys()->first() : '-' }}</p>
                    <p class="stat-sub">terbanyak</p>
                </div>
                <div class="stat-card border-canopy-700">
                    <p class="stat-label">Kepatuhan Konservasi</p>
                    <p class="stat-value" id="kpiKonservasi">-</p>
                    <p class="stat-sub">acuan min. 30%</p>
                </div>
                <div class="stat-card border-clay-500">
                    <p class="stat-label">Pengingat Aktif</p>
                    <p class="stat-value text-clay-500" id="kpiPengingat">0</p>
                    <p class="stat-sub">perlu tindak lanjut</p>
                </div>
            </div>

            <!-- Quick status chips -->
            <div class="flex flex-wrap gap-2" id="statusChips">
                <button data-chip="all" onclick="setChipFilter('all')" class="chip-btn chip-active" data-color="canopy">
                    <i class="fas fa-layer-group mr-1"></i> Semua <span class="chip-count">({{ $forestLands->count() }})</span>
                </button>
                <button data-chip="Konservasi" onclick="setChipFilter('Konservasi')" class="chip-btn" data-color="canopy">
                    <i class="fas fa-leaf mr-1"></i> Konservasi <span class="chip-count">({{ $forestLands->where('status', 'Konservasi')->count() }})</span>
                </button>
                <button data-chip="Produksi" onclick="setChipFilter('Produksi')" class="chip-btn" data-color="bark">
                    <i class="fas fa-industry mr-1"></i> Produksi <span class="chip-count">({{ $forestLands->where('status', 'Produksi')->count() }})</span>
                </button>
                <button data-chip="Reboisasi" onclick="setChipFilter('Reboisasi')" class="chip-btn" data-color="resin">
                    <i class="fas fa-seedling mr-1"></i> Reboisasi <span class="chip-count">({{ $forestLands->where('status', 'Reboisasi')->count() }})</span>
                </button>
            </div>

            <!-- Reminder + Recent activity widgets -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-md border border-canopy-100 overflow-hidden">
                    <div class="panel-header bg-clay-500"><i class="fas fa-bell"></i><span>Pengingat Perawatan &amp; Tindak Lanjut</span></div>
                    <div id="reminderList" class="divide-y divide-gray-100 max-h-72 overflow-y-auto"></div>
                </div>
                <div class="bg-white rounded-lg shadow-md border border-canopy-100 overflow-hidden">
                    <div class="panel-header bg-canopy-700"><i class="fas fa-clock-rotate-left"></i><span>Aktivitas Terbaru</span></div>
                    <div id="recentActivityList" class="divide-y divide-gray-100 max-h-72 overflow-y-auto"></div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="filter-card bg-white rounded-lg shadow-md p-6 border border-canopy-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-display font-semibold text-canopy-900 flex items-center"><i class="fas fa-filter text-resin-500 mr-2"></i> Filter &amp; Pencarian</h3>
                    <button onclick="resetFilters()" class="text-sm text-gray-500 hover:text-canopy-700 transition flex items-center"><i class="fas fa-rotate-left mr-1"></i> Reset</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="field-label"><i class="fas fa-search mr-1"></i> Cari Nama Lahan</label>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Ketik nama lahan... (tekan /)" class="field-input pr-9">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-300"></i>
                        </div>
                    </div>
                    <div>
                        <label class="field-label"><i class="fas fa-tag mr-1"></i> Status Lahan</label>
                        <select id="statusFilter" class="field-input">
                            <option value="all">Semua Status</option>
                            <option value="Konservasi">Konservasi</option>
                            <option value="Produksi">Produksi</option>
                            <option value="Reboisasi">Reboisasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="field-label"><i class="fas fa-ruler-combined mr-1"></i> Ukuran Lahan</label>
                        <select id="sizeFilter" class="field-input">
                            <option value="all">Semua Ukuran</option>
                            <option value="small">Kecil (&lt; 10 Ha)</option>
                            <option value="medium">Sedang (10-50 Ha)</option>
                            <option value="large">Besar (&gt; 50 Ha)</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <label for="perPage" class="font-medium text-gray-700">Baris per halaman:</label>
                        <select id="perPage" class="border border-gray-300 rounded-md px-2 py-1 focus:border-canopy-500 focus:outline-none">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="9999">Semua</option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="exportCSV()" class="btn-outline"><i class="fas fa-file-csv"></i><span>Export CSV</span></button>
                        <button onclick="printPage()" class="btn-outline-neutral"><i class="fas fa-print"></i><span>Cetak</span></button>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-lg shadow-md border border-canopy-100 overflow-hidden">
                <div class="panel-header bg-gradient-to-r from-canopy-800 to-canopy-600">
                    <div class="flex items-center space-x-2"><i class="fas fa-table"></i><span>Daftar Lahan Perhutanan</span></div>
                    <button onclick="switchPage('tambah-lahan')" class="ml-auto bg-resin-500 hover:bg-resin-600 text-canopy-900 px-3 py-1.5 rounded-md font-semibold text-xs shadow transition flex items-center space-x-1">
                        <i class="fas fa-plus"></i><span>Catat Lahan</span>
                    </button>
                </div>

                @if($forestLands->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-canopy-50">
                                <tr>
                                    <th class="th-cell">No</th>
                                    <th class="th-cell cursor-pointer select-none" onclick="setSort('nama_lahan')">Nama Lahan <i class="fas fa-sort ml-1 text-gray-400 sort-icon" data-sort-key="nama_lahan"></i></th>
                                    <th class="th-cell cursor-pointer select-none" onclick="setSort('luas_hektar')">Luas (Ha) <i class="fas fa-sort ml-1 text-gray-400 sort-icon" data-sort-key="luas_hektar"></i></th>
                                    <th class="th-cell cursor-pointer select-none" onclick="setSort('status')">Status <i class="fas fa-sort ml-1 text-gray-400 sort-icon" data-sort-key="status"></i></th>
                                    <th class="th-cell">Penanggung Jawab</th>
                                    <th class="th-cell no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @foreach($forestLands as $index => $land)
                                    <tr class="land-row hover:bg-canopy-50/60 transition duration-150"
                                        data-id="{{ $land->id }}"
                                        data-name="{{ strtolower($land->nama_lahan) }}"
                                        data-status="{{ $land->status }}"
                                        data-luas="{{ $land->luas_hektar }}">
                                        <td class="td-cell row-number"><span class="font-mono font-bold text-gray-500">{{ $index + 1 }}</span></td>
                                        <td class="td-cell font-semibold text-gray-900">{{ $land->nama_lahan }}</td>
                                        <td class="td-cell font-mono font-bold text-canopy-700">{{ number_format($land->luas_hektar, 2) }} Ha</td>
                                        <td class="td-cell">
                                            <span class="status-badge status-{{ $land->status }}">{{ $land->status }}</span>
                                        </td>
                                        <td class="td-cell text-sm text-gray-500" data-pic-for="{{ $land->id }}">&mdash;</td>
                                        <td class="td-cell no-print">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('forest.edit', $land->id) }}" class="action-btn bg-resin-500 hover:bg-resin-600" title="Edit lahan"><i class="fas fa-pen"></i></a>
                                                <form action="{{ route('forest.destroy', $land->id) }}" method="POST" class="inline delete-form">
                                                    @csrf @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)" class="action-btn bg-clay-500 hover:bg-clay-600" title="Hapus lahan"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="noResults" class="hidden text-center py-12">
                        <i class="fas fa-magnifying-glass text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-500 font-medium">Tidak ada lahan yang cocok dengan filter Anda.</p>
                        <button onclick="resetFilters()" class="mt-3 text-canopy-700 hover:text-canopy-900 text-sm font-semibold"><i class="fas fa-rotate-left mr-1"></i> Reset filter</button>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-4 border-t border-gray-100 bg-canopy-50/50">
                        <p class="text-sm text-gray-500" id="paginationInfo">Menampilkan data</p>
                        <div class="flex items-center space-x-1" id="paginationControls"></div>
                    </div>
                @else
                    <div class="text-center py-14">
                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-500 mb-4">Belum ada data lahan.</p>
                        <button onclick="switchPage('tambah-lahan')" class="btn-primary"><i class="fas fa-plus"></i><span>Tambah Lahan Pertama</span></button>
                    </div>
                @endif
            </div>
        </section>

        <!-- ============ TAMBAH LAHAN PAGE ============ -->
        <section id="page-tambah-lahan" class="page-section hidden space-y-6">
            <div class="flex items-center space-x-3 mb-2 border-b border-canopy-100 pb-5">
                <button onclick="switchPage('dashboard')" class="p-2 bg-white rounded-md shadow border border-canopy-100 text-canopy-700 hover:bg-canopy-50" aria-label="Kembali ke dashboard"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-resin-600 font-semibold mb-1">Pendaftaran Blok Baru</p>
                    <h2 class="text-3xl font-display font-semibold text-canopy-900">Tambah Lahan Baru</h2>
                    <p class="text-gray-600">Daftarkan blok lahan komoditas perhutanan baru ke dalam sistem</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md border-t-4 border-canopy-600 p-6 sm:p-8">
                    <form method="POST" action="{{ route('forest.store') }}" class="space-y-6" id="addForm" onsubmit="return validateAddForm()">
                        @csrf

                        <div>
                            <label class="field-label text-sm font-semibold"><i class="fas fa-signature text-resin-500 mr-1"></i> Nama Lahan / Blok Hutan</label>
                            <input type="text" name="nama_lahan" id="nama_lahan" required minlength="3"
                                   placeholder="Contoh: Blok RPH Mangunan A1"
                                   class="field-input text-base" oninput="updatePreview()">
                            <p class="text-xs text-gray-400 mt-1.5">Gunakan nama yang jelas agar mudah dikenali pada tabel &amp; grafik.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="field-label text-sm font-semibold"><i class="fas fa-ruler-combined text-resin-500 mr-1"></i> Luas Lahan (Hektar)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" min="0.01" name="luas_hektar" id="luas_hektar" required placeholder="0.00" class="field-input text-base" oninput="updatePreview()">
                                    <span class="absolute right-4 top-3.5 text-sm text-gray-400 font-bold">Ha</span>
                                </div>
                            </div>
                            <div>
                                <label class="field-label text-sm font-semibold"><i class="fas fa-tag text-resin-500 mr-1"></i> Status Pemanfaatan</label>
                                <select name="status" id="status" required class="field-input text-base" onchange="updatePreview()">
                                    <option value="Konservasi">Konservasi</option>
                                    <option value="Produksi">Produksi</option>
                                    <option value="Reboisasi">Reboisasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="field-label text-sm font-semibold"><i class="fas fa-user-tie text-resin-500 mr-1"></i> Penanggung Jawab (PIC)</label>
                                <input type="text" name="penanggung_jawab" id="penanggung_jawab" placeholder="Contoh: Mantri Hutan - Budi S." class="field-input text-base" oninput="updatePreview()">
                            </div>
                            <div>
                                <label class="field-label text-sm font-semibold"><i class="fas fa-location-dot text-resin-500 mr-1"></i> Koordinat GPS <span class="text-gray-400 font-normal">(opsional)</span></label>
                                <input type="text" name="koordinat" id="koordinat" placeholder="-7.8523, 110.3947" class="field-input text-base">
                            </div>
                        </div>

                        <div>
                            <label class="field-label text-sm font-semibold"><i class="fas fa-note-sticky text-resin-500 mr-1"></i> Keterangan / Nomor Izin <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea name="keterangan" id="keterangan" rows="2" placeholder="Contoh: SK Penetapan No. 123/KPTS/2024, berlaku s.d. 2029" class="field-input text-base"></textarea>
                        </div>

                        <!-- Pilihan status bergambar -->
                        <div>
                            <label class="field-label text-sm font-semibold mb-3">Pilih Cepat Status</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <button type="button" onclick="quickStatus('Konservasi', event)" class="status-quick-btn border-canopy-200 hover:border-canopy-500 bg-canopy-50">
                                    <i class="fas fa-leaf text-canopy-700 text-lg mb-1"></i>
                                    <p class="font-semibold text-canopy-800 text-sm">Konservasi</p>
                                    <p class="text-xs text-canopy-600">Perlindungan ekosistem</p>
                                </button>
                                <button type="button" onclick="quickStatus('Produksi', event)" class="status-quick-btn border-bark-200 hover:border-bark-500 bg-bark-100/60">
                                    <i class="fas fa-industry text-bark-600 text-lg mb-1"></i>
                                    <p class="font-semibold text-bark-700 text-sm">Produksi</p>
                                    <p class="text-xs text-bark-600">Hasil hutan komersial</p>
                                </button>
                                <button type="button" onclick="quickStatus('Reboisasi', event)" class="status-quick-btn border-resin-200 hover:border-resin-500 bg-resin-100/60">
                                    <i class="fas fa-seedling text-resin-600 text-lg mb-1"></i>
                                    <p class="font-semibold text-resin-700 text-sm">Reboisasi</p>
                                    <p class="text-xs text-resin-600">Penanaman kembali</p>
                                </button>
                            </div>
                        </div>

                        <div class="bg-canopy-50 border border-canopy-100 rounded-md p-4 text-xs text-canopy-700 flex items-start space-x-2">
                            <i class="fas fa-circle-info mt-0.5"></i>
                            <span>Data akan langsung tampil pada Dashboard dan grafik Analisis Lahan setelah disimpan. Field Penanggung Jawab, Koordinat, dan Keterangan memerlukan kolom tambahan pada tabel <code class="font-mono">forest_lands</code> di sisi server.</span>
                        </div>

                        <div class="pt-2 flex flex-col-reverse sm:flex-row justify-end gap-3">
                            <button type="button" onclick="switchPage('dashboard')" class="btn-outline-neutral">Batal</button>
                            <button type="submit" class="btn-primary"><i class="fas fa-save"></i><span>Simpan Data Lahan</span></button>
                        </div>
                    </form>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-md border-t-4 border-resin-500 p-6">
                        <h4 class="panel-title"><i class="fas fa-eye text-resin-600 mr-2"></i> Pratinjau Data</h4>
                        <div class="border-2 border-dashed border-gray-200 rounded-md p-4 space-y-3">
                            <div><p class="text-xs text-gray-400 uppercase tracking-wide">Nama Lahan</p><p id="previewNama" class="font-bold text-gray-800 text-lg">-</p></div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                <div><p class="text-xs text-gray-400 uppercase tracking-wide">Luas</p><p id="previewLuas" class="font-mono font-bold text-canopy-700">0.00 Ha</p></div>
                                <span id="previewStatus" class="status-badge status-Konservasi">Konservasi</span>
                            </div>
                            <div class="pt-2 border-t border-gray-100">
                                <p class="text-xs text-gray-400 uppercase tracking-wide">Penanggung Jawab</p>
                                <p id="previewPic" class="text-sm text-gray-700">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md border-t-4 border-bark-500 p-6">
                        <h4 class="panel-title"><i class="fas fa-lightbulb text-bark-500 mr-2"></i> Tips Pengisian</h4>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start space-x-2"><i class="fas fa-check text-canopy-600 mt-0.5"></i><span>Sertakan kode petak/RPH pada nama agar mudah dicari, contoh <em>"RPH Mangunan A1"</em>.</span></li>
                            <li class="flex items-start space-x-2"><i class="fas fa-check text-canopy-600 mt-0.5"></i><span>Luas lahan diinput dalam satuan hektar, gunakan titik desimal misal <em>12.50</em>.</span></li>
                            <li class="flex items-start space-x-2"><i class="fas fa-check text-canopy-600 mt-0.5"></i><span>Catat penanggung jawab agar jelas siapa yang harus dihubungi untuk kegiatan lapangan.</span></li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-lg shadow-md border-t-4 border-canopy-500 p-6">
                        <h4 class="panel-title"><i class="fas fa-chart-simple text-canopy-600 mr-2"></i> Ringkasan Saat Ini</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-gray-500">Total Lahan</span><span class="font-mono font-bold text-canopy-700">{{ $forestLands->count() }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Total Luas</span><span class="font-mono font-bold text-canopy-700">{{ number_format($forestLands->sum('luas_hektar'), 2) }} Ha</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ KEGIATAN LAHAN PAGE ============ -->
        <section id="page-kegiatan" class="page-section hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 border-b border-canopy-100 pb-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-resin-600 font-semibold mb-1">Buku Lapangan</p>
                    <h2 class="text-3xl font-display font-semibold text-canopy-900">Kegiatan &amp; Riwayat Lahan</h2>
                    <p class="text-gray-600 mt-1">Catat penanaman, pemeliharaan, penebangan, panen, dan inspeksi setiap blok lahan</p>
                </div>
                <button onclick="printPage()" class="no-print btn-outline-neutral self-start"><i class="fas fa-print"></i><span>Cetak</span></button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white rounded-lg shadow-md border-t-4 border-canopy-600 p-6">
                    <h4 class="panel-title"><i class="fas fa-pen-to-square text-resin-600 mr-2"></i> Catat Kegiatan Baru</h4>
                    <form id="kegiatanForm" class="space-y-4" onsubmit="return submitKegiatan(event)">
                        <div>
                            <label class="field-label text-sm font-semibold">Lahan</label>
                            <select id="k_lahan" required class="field-input"></select>
                        </div>
                        <div>
                            <label class="field-label text-sm font-semibold">Jenis Kegiatan</label>
                            <select id="k_jenis" required class="field-input">
                                <option value="Penanaman">Penanaman</option>
                                <option value="Pemeliharaan">Pemeliharaan</option>
                                <option value="Penebangan">Penebangan</option>
                                <option value="Panen">Panen</option>
                                <option value="Inspeksi">Inspeksi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="field-label text-sm font-semibold">Tanggal</label>
                                <input type="date" id="k_tanggal" required class="field-input">
                            </div>
                            <div>
                                <label class="field-label text-sm font-semibold">Tindak Lanjut <span class="text-gray-400 font-normal">(opsional)</span></label>
                                <input type="date" id="k_tindaklanjut" class="field-input">
                            </div>
                        </div>
                        <div>
                            <label class="field-label text-sm font-semibold">Petugas</label>
                            <input type="text" id="k_petugas" placeholder="Nama petugas lapangan" required class="field-input">
                        </div>
                        <div>
                            <label class="field-label text-sm font-semibold">Catatan</label>
                            <textarea id="k_catatan" rows="3" placeholder="Detail kegiatan di lapangan..." class="field-input"></textarea>
                        </div>
                        <div class="space-y-2">
                            <button type="submit" id="kegiatanSubmitBtn" class="btn-primary w-full justify-center"><i class="fas fa-save"></i><span>Simpan Kegiatan</span></button>
                            <button type="button" id="kegiatanCancelBtn" onclick="cancelEditKegiatan()" class="hidden w-full text-center text-sm text-gray-500 hover:text-clay-600 underline">Batal edit kegiatan</button>
                        </div>
                    </form>
                </div>

                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-lg shadow-md border border-canopy-100 p-4 flex flex-wrap gap-3 items-center">
                        <select id="kFilterLahan" class="field-input !py-1.5 !w-auto text-sm" onchange="renderKegiatanList()"><option value="all">Semua Lahan</option></select>
                        <select id="kFilterJenis" class="field-input !py-1.5 !w-auto text-sm" onchange="renderKegiatanList()">
                            <option value="all">Semua Jenis</option>
                            <option value="Penanaman">Penanaman</option>
                            <option value="Pemeliharaan">Pemeliharaan</option>
                            <option value="Penebangan">Penebangan</option>
                            <option value="Panen">Panen</option>
                            <option value="Inspeksi">Inspeksi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <button onclick="exportKegiatanCSV()" class="btn-outline ml-auto"><i class="fas fa-file-csv"></i><span>Export CSV</span></button>
                    </div>

                    <div class="bg-white rounded-lg shadow-md border border-canopy-100 overflow-hidden">
                        <div class="panel-header bg-gradient-to-r from-canopy-800 to-canopy-600"><i class="fas fa-timeline"></i><span>Lini Masa Kegiatan</span></div>
                        <div id="kegiatanTimeline" class="divide-y divide-gray-100 max-h-[560px] overflow-y-auto"></div>
                        <div id="kegiatanEmpty" class="hidden text-center py-12">
                            <i class="fas fa-clipboard text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">Belum ada kegiatan tercatat untuk filter ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ PRODUKSI HASIL HUTAN PAGE ============ -->
        <section id="page-produksi" class="page-section hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 border-b border-canopy-100 pb-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-resin-600 font-semibold mb-1">Buku Hasil Hutan</p>
                    <h2 class="text-3xl font-display font-semibold text-canopy-900">Produksi Hasil Hutan</h2>
                    <p class="text-gray-600 mt-1">Catat dan pantau hasil kayu, getah, dan komoditas hutan lainnya per lahan</p>
                </div>
                <button onclick="printPage()" class="no-print btn-outline-neutral self-start"><i class="fas fa-print"></i><span>Cetak</span></button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="stat-card border-bark-500"><p class="stat-label">Total Volume Kayu</p><p class="stat-value text-bark-600" id="sumKayu">0</p><p class="stat-sub">m&sup3;</p></div>
                <div class="stat-card border-resin-500"><p class="stat-label">Total Getah / Non-kayu</p><p class="stat-value text-resin-600" id="sumGetah">0</p><p class="stat-sub">kg</p></div>
                <div class="stat-card border-canopy-600"><p class="stat-label">Total Pencatatan</p><p class="stat-value text-canopy-700" id="sumEntri">0</p><p class="stat-sub">entri produksi</p></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white rounded-lg shadow-md border-t-4 border-bark-500 p-6">
                    <h4 class="panel-title"><i class="fas fa-plus text-bark-600 mr-2"></i> Catat Hasil Produksi</h4>
                    <form id="produksiForm" class="space-y-4" onsubmit="return submitProduksi(event)">
                        <div>
                            <label class="field-label text-sm font-semibold">Lahan</label>
                            <select id="p_lahan" required class="field-input"></select>
                        </div>
                        <div>
                            <label class="field-label text-sm font-semibold">Komoditas</label>
                            <select id="p_komoditas" required class="field-input">
                                <option value="Kayu Jati">Kayu Jati</option>
                                <option value="Kayu Pinus">Kayu Pinus</option>
                                <option value="Kayu Mahoni">Kayu Mahoni</option>
                                <option value="Getah Pinus">Getah Pinus</option>
                                <option value="Bambu">Bambu</option>
                                <option value="Madu Hutan">Madu Hutan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="field-label text-sm font-semibold">Jumlah</label>
                                <input type="number" step="0.01" min="0.01" id="p_jumlah" required class="field-input">
                            </div>
                            <div>
                                <label class="field-label text-sm font-semibold">Satuan</label>
                                <select id="p_satuan" required class="field-input">
                                    <option value="m3">m&sup3;</option>
                                    <option value="kg">kg</option>
                                    <option value="batang">batang</option>
                                    <option value="liter">liter</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="field-label text-sm font-semibold">Tanggal</label>
                            <input type="date" id="p_tanggal" required class="field-input">
                        </div>
                        <div>
                            <label class="field-label text-sm font-semibold">Catatan</label>
                            <textarea id="p_catatan" rows="2" placeholder="Kualitas, tujuan distribusi, dsb." class="field-input"></textarea>
                        </div>
                        <div class="space-y-2">
                            <button type="submit" id="produksiSubmitBtn" class="btn-primary w-full justify-center bg-bark-600 hover:bg-bark-700"><i class="fas fa-save"></i><span>Simpan Produksi</span></button>
                            <button type="button" id="produksiCancelBtn" onclick="cancelEditProduksi()" class="hidden w-full text-center text-sm text-gray-500 hover:text-clay-600 underline">Batal edit produksi</button>
                        </div>
                    </form>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow-md border-t-4 border-bark-500 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="panel-title mb-0"><i class="fas fa-chart-line text-bark-600 mr-2"></i> Tren Produksi per Bulan</h4>
                            <button onclick="downloadChart('produksiChart','tren-produksi')" class="text-gray-400 hover:text-bark-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                        </div>
                        <div class="relative" style="height:280px;"><canvas id="produksiChart"></canvas></div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md border border-canopy-100 overflow-hidden">
                        <div class="panel-header bg-gradient-to-r from-bark-700 to-bark-500">
                            <i class="fas fa-list"></i><span>Riwayat Produksi</span>
                            <button onclick="exportProduksiCSV()" class="ml-auto bg-white text-bark-700 hover:bg-bark-100 px-3 py-1.5 rounded-md font-semibold text-xs shadow transition flex items-center space-x-1"><i class="fas fa-file-csv"></i><span>Export</span></button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-canopy-50">
                                    <tr>
                                        <th class="th-cell">Tanggal</th>
                                        <th class="th-cell">Lahan</th>
                                        <th class="th-cell">Komoditas</th>
                                        <th class="th-cell">Jumlah</th>
                                        <th class="th-cell no-print">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="produksiTableBody" class="bg-white divide-y divide-gray-200"></tbody>
                            </table>
                        </div>
                        <div id="produksiEmpty" class="hidden text-center py-12">
                            <i class="fas fa-box-open text-gray-300 text-5xl mb-3"></i>
                            <p class="text-gray-500">Belum ada data produksi tercatat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ ANALISIS PAGE ============ -->
        <section id="page-analisis" class="page-section hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 border-b border-canopy-100 pb-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-resin-600 font-semibold mb-1">Telaah Data</p>
                    <h2 class="text-3xl font-display font-semibold text-canopy-900">Analisis Visual Data Lahan</h2>
                    <p class="text-gray-600 mt-1">Distribusi luas lahan berdasarkan status wilayah</p>
                </div>
                <button onclick="printPage()" class="no-print btn-outline-neutral self-start"><i class="fas fa-print"></i><span>Cetak Analisis</span></button>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-canopy-600">
                <h4 class="panel-title"><i class="fas fa-wand-magic-sparkles text-resin-500 mr-2"></i> Ringkasan Insight</h4>
                <ul id="insightList" class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start space-x-2"><i class="fas fa-circle-notch fa-spin text-gray-300 mt-1"></i><span>Menghitung insight...</span></li>
                </ul>
            </div>

            <!-- Signature: tree-ring conservation gauge -->
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-canopy-600">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <div class="shrink-0 mx-auto sm:mx-0">
                        <svg width="160" height="160" viewBox="0 0 160 160" id="ringGauge">
                            <circle cx="80" cy="80" r="70" fill="none" stroke="#eef2ed" stroke-width="14"/>
                            <circle id="ringTarget" cx="80" cy="80" r="70" fill="none" stroke="#a9cba0" stroke-width="2" stroke-dasharray="4 4" transform="rotate(-90 80 80)"/>
                            <circle id="ringProgress" cx="80" cy="80" r="70" fill="none" stroke="#2f6349" stroke-width="14" stroke-linecap="round" stroke-dasharray="0 440" transform="rotate(-90 80 80)" style="transition: stroke-dasharray 1s ease-out, stroke .4s;"/>
                            <text x="80" y="76" text-anchor="middle" font-family="IBM Plex Mono, monospace" font-size="26" font-weight="600" fill="#152e24" id="ringPct">0%</text>
                            <text x="80" y="96" text-anchor="middle" font-family="Public Sans, sans-serif" font-size="10" fill="#6b7280">konservasi</text>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="panel-title mb-1"><i class="fas fa-shield-halved text-canopy-600 mr-2"></i>Rasio Kawasan Konservasi</h4>
                        <p class="text-xs text-gray-400 mb-2">Seperti lingkar tahun pohon &mdash; setiap cincin merepresentasikan proporsi luas terhadap acuan kebijakan minimum <b class="text-gray-600">30%</b> dari total luas.</p>
                        <p id="conservationNote" class="text-sm text-gray-600"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-canopy-100">
                <div class="panel-header bg-gradient-to-r from-canopy-800 to-canopy-600"><i class="fas fa-table-list"></i><span>Ringkasan Detail per Status</span></div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-canopy-50">
                            <tr>
                                <th class="th-cell">Status</th>
                                <th class="th-cell">Jumlah Lahan</th>
                                <th class="th-cell">Total Luas (Ha)</th>
                                <th class="th-cell">Rata-rata Luas (Ha)</th>
                                <th class="th-cell">% dari Total Luas</th>
                            </tr>
                        </thead>
                        <tbody id="summaryTableBody" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="chart-card border-canopy-600">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="panel-title mb-0"><i class="fas fa-chart-pie text-canopy-600 mr-2"></i> Proporsi Distribusi Lahan (Ha)</h4>
                        <button onclick="downloadChart('pieChart','proporsi-distribusi-lahan')" class="no-print text-gray-400 hover:text-canopy-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;"><canvas id="pieChart"></canvas></div>
                    <div class="mt-4 text-center bg-canopy-50 p-2 rounded-md"><p class="text-sm text-gray-600">Akumulasi Total: <span id="pieTotal" class="font-mono font-bold text-canopy-700">0</span> Ha</p></div>
                </div>

                <div class="chart-card border-bark-500">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="panel-title mb-0"><i class="fas fa-chart-bar text-bark-600 mr-2"></i> Perbandingan Luas Berdasarkan Status</h4>
                        <button onclick="downloadChart('barChart','perbandingan-luas-status')" class="no-print text-gray-400 hover:text-canopy-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;"><canvas id="barChart"></canvas></div>
                    <div class="mt-4 text-center bg-bark-100/60 p-2 rounded-md"><p class="text-sm text-gray-600">Akumulasi Total: <span id="barTotal" class="font-mono font-bold text-bark-600">0</span> Ha</p></div>
                </div>

                <div class="chart-card border-resin-500">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="panel-title mb-0"><i class="fas fa-list-ol text-resin-600 mr-2"></i> Jumlah Blok Lahan per Status</h4>
                        <button onclick="downloadChart('donutChart','jumlah-blok-per-status')" class="no-print text-gray-400 hover:text-canopy-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;"><canvas id="donutChart"></canvas></div>
                    <div class="mt-4 text-center bg-resin-100/60 p-2 rounded-md"><p class="text-sm text-gray-600">Total Blok: <span id="donutTotal" class="font-mono font-bold text-resin-600">0</span> lahan</p></div>
                </div>

                <div class="chart-card border-canopy-700">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="panel-title mb-0"><i class="fas fa-ranking-star text-canopy-700 mr-2"></i> Top 5 Lahan Terluas</h4>
                        <button onclick="downloadChart('topChart','top-5-lahan-terluas')" class="no-print text-gray-400 hover:text-canopy-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 300px;"><canvas id="topChart"></canvas></div>
                    <div class="mt-4 text-center bg-canopy-50 p-2 rounded-md"><p class="text-sm text-gray-600">Berdasarkan luas hektar tertinggi saat ini</p></div>
                </div>

                <div class="chart-card border-canopy-700 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="panel-title mb-0"><i class="fas fa-layer-group text-canopy-700 mr-2"></i> Distribusi Ukuran Lahan</h4>
                        <button onclick="downloadChart('sizeChart','distribusi-ukuran-lahan')" class="no-print text-gray-400 hover:text-canopy-600 transition" title="Unduh grafik"><i class="fas fa-download"></i></button>
                    </div>
                    <div class="relative" style="height: 280px;"><canvas id="sizeChart"></canvas></div>
                    <div class="mt-4 text-center bg-canopy-50 p-2 rounded-md"><p class="text-sm text-gray-600">Kecil &lt; 10 Ha &nbsp;&middot;&nbsp; Sedang 10&ndash;50 Ha &nbsp;&middot;&nbsp; Besar &gt; 50 Ha</p></div>
                </div>
            </div>
        </section>

    </div>

    <style type="text/tailwindcss">
        @keyframes fade-in { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .page-section:not(.hidden) { animation: fade-in .35s ease-out forwards; }

        .nav-tab-btn { @apply px-3 py-2 rounded-md text-sm font-medium transition duration-150 flex items-center space-x-2 text-canopy-100 hover:bg-canopy-800; }
        .nav-tab-btn.active-tab { @apply bg-resin-500 text-canopy-900 shadow; }
        .mnav-tab-btn { @apply w-full text-left text-canopy-100 hover:bg-canopy-800 px-4 py-2.5 rounded-md font-medium flex items-center space-x-2; }
        .mnav-tab-btn.active-tab { @apply bg-resin-500 text-canopy-900; }

        .field-label { @apply flex items-center text-sm font-medium text-gray-700 mb-2; }
        .field-input { @apply w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-canopy-500 focus:border-canopy-500 focus:outline-none transition; }

        .stat-card { @apply bg-white rounded-lg shadow-md p-5 border-t-4 hover:shadow-lg hover:-translate-y-0.5 transition duration-200; }
        .stat-label { @apply text-gray-500 text-[11px] font-semibold uppercase tracking-wide; }
        .stat-value { @apply text-3xl font-mono font-bold mt-1; }
        .stat-sub { @apply text-xs text-gray-400 mt-1; }

        .panel-header { @apply px-6 py-3.5 flex items-center space-x-2 text-white font-display font-semibold; }
        .panel-title { @apply text-sm font-bold text-gray-700 uppercase tracking-wide mb-4 flex items-center; }

        .chip-btn { @apply px-4 py-2 rounded-full text-sm font-semibold border-2 bg-white transition; }
        .chip-btn[data-color="canopy"] { @apply border-canopy-600 text-canopy-700 hover:bg-canopy-50; }
        .chip-btn[data-color="bark"] { @apply border-bark-500 text-bark-600 hover:bg-bark-100/60; }
        .chip-btn[data-color="resin"] { @apply border-resin-500 text-resin-700 hover:bg-resin-100/60; }
        .chip-btn.chip-active[data-color="canopy"] { @apply bg-canopy-600 text-white; }
        .chip-btn.chip-active[data-color="bark"] { @apply bg-bark-500 text-white; }
        .chip-btn.chip-active[data-color="resin"] { @apply bg-resin-500 text-white; }

        .th-cell { @apply px-6 py-3.5 text-left text-xs font-bold text-canopy-800 uppercase tracking-wider; }
        .td-cell { @apply px-6 py-4 whitespace-nowrap; }

        .status-badge { @apply px-3 py-1 rounded-full text-xs font-bold; }
        .status-Konservasi { @apply bg-canopy-100 text-canopy-800; }
        .status-Produksi { @apply bg-bark-100 text-bark-700; }
        .status-Reboisasi { @apply bg-resin-100 text-resin-700; }

        .action-btn { @apply text-white px-2.5 py-1.5 rounded-md text-xs font-semibold shadow-sm transition hover:brightness-110; }
        .btn-primary { @apply bg-canopy-700 hover:bg-canopy-800 text-white px-5 py-2.5 rounded-md font-medium shadow-md transition flex items-center justify-center space-x-2; }
        .btn-outline { @apply bg-white border-2 border-canopy-600 text-canopy-700 hover:bg-canopy-50 px-3 py-2 rounded-md text-sm font-semibold transition flex items-center space-x-1; }
        .btn-outline-neutral { @apply bg-white border-2 border-gray-300 text-gray-600 hover:bg-gray-50 px-3 py-2 rounded-md text-sm font-semibold transition flex items-center space-x-1; }
        .status-quick-btn { @apply border-2 rounded-md p-3 text-left transition; }

        .chart-card { @apply bg-white rounded-lg shadow-md p-6 border-t-4; }

        #tableBody tr.hidden-row { display: none !important; }
        .page-num-btn.active-page { background-color: #2f6349; color: #fff; border-color: #2f6349; }

        button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid #3f7a5c; outline-offset: 2px;
        }

        @media print {
            nav, #mobileMenu, #flashSuccess, #flashError, #liveClock,
            .filter-card, #noResults, #paginationControls, #paginationInfo,
            .delete-form, .sort-icon,
            #searchInput, .relative i.fa-search, .no-print {
                display: none !important;
            }
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
        // ================= Navigation =================
        const ALL_TABS = ['dashboard', 'tambah-lahan', 'kegiatan', 'produksi', 'analisis'];

        async function switchPage(pageId) {
            document.querySelectorAll('.page-section').forEach(section => section.classList.add('hidden'));
            document.getElementById(`page-${pageId}`).classList.remove('hidden');

            ALL_TABS.forEach(tab => {
                document.getElementById(`tab-${tab}`)?.classList.remove('active-tab');
                document.getElementById(`mtab-${tab}`)?.classList.remove('active-tab');
            });
            document.getElementById(`tab-${pageId}`)?.classList.add('active-tab');
            document.getElementById(`mtab-${pageId}`)?.classList.add('active-tab');

            if (pageId === 'analisis') { await fetchKegiatan(); initCharts(); }
            if (pageId === 'kegiatan') { populateLahanSelects(); await fetchKegiatan(); renderKegiatanList(); }
            if (pageId === 'produksi') { populateLahanSelects(); await fetchProduksi(); renderProduksiAll(); }
            if (pageId === 'dashboard') { await fetchKegiatan(); renderReminders(); renderRecentActivity(); updateDashboardKpis(); }
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const btn = document.getElementById('mobileMenuBtn');
            const willShow = menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            btn?.setAttribute('aria-expanded', String(willShow));
        }
        window.addEventListener('resize', () => { if (window.innerWidth >= 1024) document.getElementById('mobileMenu').classList.add('hidden'); });

        // ================= Flash messages =================
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
                const t = setInterval(() => { w -= 100 / 50; bar.style.width = Math.max(w, 0) + '%'; if (w <= 0) { clearInterval(t); dismissFlash(id); } }, 100);
            }
        });

        // ================= Live clock =================
        function updateClock() {
            const el = document.getElementById('liveClock');
            if (!el) return;
            const now = new Date();
            el.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }) + ' \u00b7 ' + now.toLocaleTimeString('id-ID');
        }
        updateClock();
        setInterval(updateClock, 1000);

        // ================= Delete confirmation =================
        function confirmDelete(btn) {
            const form = btn.closest('form');
            Swal.fire({
                title: 'Hapus lahan ini?', text: 'Data yang sudah dihapus tidak dapat dikembalikan.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#b3462c', cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        }

        // ================= Add form: preview & quick status =================
        const statusBadgeClass = { Konservasi: 'status-Konservasi', Produksi: 'status-Produksi', Reboisasi: 'status-Reboisasi' };

        function updatePreview() {
            const nama = document.getElementById('nama_lahan')?.value.trim();
            const luas = parseFloat(document.getElementById('luas_hektar')?.value);
            const status = document.getElementById('status')?.value || 'Konservasi';
            const pic = document.getElementById('penanggung_jawab')?.value.trim();

            const previewNama = document.getElementById('previewNama');
            if (!previewNama) return;
            previewNama.textContent = nama ? nama : '-';
            document.getElementById('previewLuas').textContent = (isNaN(luas) ? 0 : luas).toFixed(2) + ' Ha';
            const badge = document.getElementById('previewStatus');
            badge.textContent = status;
            badge.className = `status-badge ${statusBadgeClass[status] || statusBadgeClass.Konservasi}`;
            document.getElementById('previewPic').textContent = pic ? pic : '-';
        }

        function quickStatus(status, evt) {
            const select = document.getElementById('status');
            if (select) select.value = status;
            document.querySelectorAll('.status-quick-btn').forEach(b => b.classList.remove('ring-2', 'ring-offset-1', 'ring-canopy-500', 'ring-bark-500', 'ring-resin-500'));
            const map = { Konservasi: 'ring-canopy-500', Produksi: 'ring-bark-500', Reboisasi: 'ring-resin-500' };
            const target = evt?.currentTarget;
            if (target) target.classList.add('ring-2', 'ring-offset-1', map[status]);
            updatePreview();
        }

        function validateAddForm() {
            const luas = parseFloat(document.getElementById('luas_hektar').value);
            if (isNaN(luas) || luas <= 0) {
                Swal.fire('Luas tidak valid', 'Masukkan luas lahan lebih besar dari 0 hektar.', 'error');
                return false;
            }
            return true;
        }

        // ================= Data / Filter / Sort / Pagination (Lahan) =================
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
            if (activeIcon) activeIcon.className = `fas fa-sort-${sortDir === 'asc' ? 'up' : 'down'} ml-1 text-canopy-600 sort-icon`;
            currentPage = 1;
            applyFilters();
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
            fillPicColumn();
        }

        function fillPicColumn() {
            const pics = getPicMap();
            document.querySelectorAll('[data-pic-for]').forEach(td => {
                const id = td.getAttribute('data-pic-for');
                td.textContent = pics[id] || '\u2014';
            });
        }
        function getPicMap() {
            try { return JSON.parse(localStorage.getItem('perhutani_pic_map') || '{}'); } catch(e) { return {}; }
        }

        function renderPagination(totalPages) {
            const controls = document.getElementById('paginationControls');
            if (!controls) return;
            controls.innerHTML = '';
            if (totalPages <= 1) return;

            const makeBtn = (label, page, disabled = false, active = false) => {
                const btn = document.createElement('button');
                btn.textContent = label;
                btn.className = `page-num-btn px-3 py-1.5 text-sm rounded-md border transition ${active ? 'active-page' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100'} ${disabled ? 'opacity-40 cursor-not-allowed' : ''}`;
                if (!disabled) btn.onclick = () => { currentPage = page; applyFilters(); };
                return btn;
            };
            controls.appendChild(makeBtn('\u00ab', currentPage - 1, currentPage === 1));
            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && p !== 1 && p !== totalPages && Math.abs(p - currentPage) > 1) {
                    if (p === 2 || p === totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '\u2026';
                        dots.className = 'px-2 text-gray-400';
                        controls.appendChild(dots);
                    }
                    continue;
                }
                controls.appendChild(makeBtn(String(p), p, false, p === currentPage));
            }
            controls.appendChild(makeBtn('\u00bb', currentPage + 1, currentPage === totalPages));
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

        // ================= Print =================
        function printPage() {
            const analisisVisible = !document.getElementById('page-analisis').classList.contains('hidden');
            if (analisisVisible) { initCharts(); setTimeout(() => window.print(), 300); }
            else window.print();
        }

        // ================= Export CSV (lahan) =================
        function exportCSV() {
            const data = currentFilteredData();
            if (data.length === 0) { Swal.fire('Tidak ada data', 'Tidak ada data untuk diekspor sesuai filter saat ini.', 'info'); return; }
            let csv = 'Nama Lahan,Luas (Ha),Status\n';
            data.forEach(l => { csv += `"${l.nama_lahan.replace(/"/g, '""')}",${l.luas_hektar},${l.status}\n`; });
            downloadCsv(csv, `data-lahan-${new Date().toISOString().slice(0, 10)}.csv`);
        }
        function downloadCsv(csv, filename) {
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url; a.download = filename;
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // ================= Backend data: Kegiatan & Produksi =================
        const routes = {
            kegiatanIndex: "{{ route('kegiatan.index') }}",
            kegiatanStore: "{{ route('kegiatan.store') }}",
            kegiatanUpdate: (id) => `{{ url('/kegiatan') }}/${id}`,
            kegiatanDestroy: (id) => `{{ url('/kegiatan') }}/${id}`,
            produksiIndex: "{{ route('produksi.index') }}",
            produksiStore: "{{ route('produksi.store') }}",
            produksiUpdate: (id) => `{{ url('/produksi') }}/${id}`,
            produksiDestroy: (id) => `{{ url('/produksi') }}/${id}`,
        };

        function csrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }

        async function apiFetch(url, options = {}) {
            const headers = Object.assign({ 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken() }, options.headers || {});
            if (options.body && !(options.body instanceof FormData)) headers['Content-Type'] = 'application/json';
            const res = await fetch(url, { ...options, headers });
            if (!res.ok) {
                let msg = 'Permintaan gagal diproses.';
                try { const err = await res.json(); msg = err.message || msg; } catch (e) { /* ignore */ }
                throw new Error(msg);
            }
            if (res.status === 204) return null;
            return res.json();
        }

        let kegiatanCache = [];
        let produksiCache = [];

        function loadKegiatan() { return kegiatanCache; }
        function loadProduksi() { return produksiCache; }

        async function fetchKegiatan() {
            try { kegiatanCache = await apiFetch(routes.kegiatanIndex); }
            catch (err) { console.error(err); Swal.fire('Gagal memuat', 'Tidak bisa mengambil data kegiatan dari server.', 'error'); }
        }
        async function fetchProduksi() {
            try { produksiCache = await apiFetch(routes.produksiIndex); }
            catch (err) { console.error(err); Swal.fire('Gagal memuat', 'Tidak bisa mengambil data produksi dari server.', 'error'); }
        }

        function populateLahanSelects() {
            const opts = landsData.map(l => `<option value="${l.id}">${escapeHtml(l.nama_lahan)}</option>`).join('');
            ['k_lahan', 'p_lahan'].forEach(id => { const el = document.getElementById(id); if (el && !el.dataset.filled) { el.innerHTML = opts; el.dataset.filled = '1'; } });
            const kFilter = document.getElementById('kFilterLahan');
            if (kFilter && !kFilter.dataset.filled) {
                kFilter.innerHTML = '<option value="all">Semua Lahan</option>' + opts;
                kFilter.dataset.filled = '1';
            }
        }

        // ---------- Kegiatan ----------
        let editingKegiatanId = null;

        async function submitKegiatan(e) {
            e.preventDefault();
            const lahanSelect = document.getElementById('k_lahan');
            const payload = {
                forest_land_id: lahanSelect.value,
                jenis: document.getElementById('k_jenis').value,
                tanggal: document.getElementById('k_tanggal').value,
                tindak_lanjut: document.getElementById('k_tindaklanjut').value || null,
                petugas: document.getElementById('k_petugas').value,
                catatan: document.getElementById('k_catatan').value || null
            };

            try {
                if (editingKegiatanId) {
                    await apiFetch(routes.kegiatanUpdate(editingKegiatanId), { method: 'PUT', body: JSON.stringify(payload) });
                    cancelEditKegiatan(false);
                    Swal.fire({ icon: 'success', title: 'Kegiatan diperbarui', timer: 1400, showConfirmButton: false });
                } else {
                    await apiFetch(routes.kegiatanStore, { method: 'POST', body: JSON.stringify(payload) });
                    Swal.fire({ icon: 'success', title: 'Kegiatan tercatat', timer: 1400, showConfirmButton: false });
                }
                document.getElementById('kegiatanForm').reset();
                const todayIso = new Date().toISOString().slice(0, 10);
                const kTanggal = document.getElementById('k_tanggal'); if (kTanggal) kTanggal.value = todayIso;
                await fetchKegiatan();
                renderKegiatanList();
                renderReminders();
                renderRecentActivity();
            } catch (err) {
                Swal.fire('Gagal menyimpan', err.message, 'error');
            }
            return false;
        }

        function editKegiatan(id) {
            const k = loadKegiatan().find(x => String(x.id) === String(id));
            if (!k) return;
            populateLahanSelects();
            document.getElementById('k_lahan').value = k.lahan_id;
            document.getElementById('k_jenis').value = k.jenis;
            document.getElementById('k_tanggal').value = k.tanggal;
            document.getElementById('k_tindaklanjut').value = k.tindaklanjut || '';
            document.getElementById('k_petugas').value = k.petugas;
            document.getElementById('k_catatan').value = k.catatan || '';
            editingKegiatanId = id;
            const btn = document.getElementById('kegiatanSubmitBtn');
            if (btn) btn.innerHTML = '<i class="fas fa-rotate"></i><span>Perbarui Kegiatan</span>';
            document.getElementById('kegiatanCancelBtn')?.classList.remove('hidden');
            document.getElementById('kegiatanForm')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function cancelEditKegiatan(doReset = true) {
            editingKegiatanId = null;
            const btn = document.getElementById('kegiatanSubmitBtn');
            if (btn) btn.innerHTML = '<i class="fas fa-save"></i><span>Simpan Kegiatan</span>';
            document.getElementById('kegiatanCancelBtn')?.classList.add('hidden');
            if (doReset) {
                document.getElementById('kegiatanForm')?.reset();
                const todayIso = new Date().toISOString().slice(0, 10);
                const kTanggal = document.getElementById('k_tanggal'); if (kTanggal) kTanggal.value = todayIso;
            }
        }

        const kegiatanIconMap = { Penanaman: 'fa-seedling', Pemeliharaan: 'fa-broom', Penebangan: 'fa-axe', Panen: 'fa-basket-shopping', Inspeksi: 'fa-magnifying-glass', Lainnya: 'fa-note-sticky' };
        const kegiatanColorMap = { Penanaman: 'canopy', Pemeliharaan: 'resin', Penebangan: 'clay', Panen: 'bark', Inspeksi: 'canopy', Lainnya: 'bark' };

        function renderKegiatanList() {
            const list = document.getElementById('kegiatanTimeline');
            const empty = document.getElementById('kegiatanEmpty');
            if (!list) return;
            const fLahan = document.getElementById('kFilterLahan')?.value || 'all';
            const fJenis = document.getElementById('kFilterJenis')?.value || 'all';
            let data = loadKegiatan().filter(k => (fLahan === 'all' || k.lahan_id == fLahan) && (fJenis === 'all' || k.jenis === fJenis));
            data.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));

            list.innerHTML = '';
            empty.classList.toggle('hidden', data.length > 0);

            data.forEach(k => {
                const icon = kegiatanIconMap[k.jenis] || 'fa-note-sticky';
                const color = kegiatanColorMap[k.jenis] || 'canopy';
                const row = document.createElement('div');
                row.className = 'p-4 flex items-start space-x-3 hover:bg-gray-50 transition';
                row.innerHTML = `
                    <div class="w-9 h-9 rounded-full bg-${color}-100 flex items-center justify-center shrink-0 mt-0.5"><i class="fas ${icon} text-${color}-700 text-sm"></i></div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-semibold text-gray-900 text-sm">${escapeHtml(k.jenis)}</span>
                            <span class="text-xs text-gray-400 font-mono">${formatTanggal(k.tanggal)}</span>
                            ${k.tindaklanjut ? `<span class="text-[11px] px-2 py-0.5 rounded-full bg-clay-100 text-clay-600 font-semibold">Tindak lanjut: ${formatTanggal(k.tindaklanjut)}</span>` : ''}
                        </div>
                        <p class="text-sm text-gray-600 mt-0.5">${escapeHtml(k.lahan_nama)} &middot; ${escapeHtml(k.petugas)}</p>
                        ${k.catatan ? `<p class="text-xs text-gray-500 mt-1">${escapeHtml(k.catatan)}</p>` : ''}
                    </div>
                    <div class="flex items-center gap-2 no-print shrink-0">
                        <button onclick="editKegiatan('${k.id}')" class="text-gray-300 hover:text-canopy-600 transition" title="Edit" aria-label="Edit kegiatan"><i class="fas fa-pen"></i></button>
                        <button onclick="deleteKegiatan('${k.id}')" class="text-gray-300 hover:text-clay-500 transition" title="Hapus" aria-label="Hapus kegiatan"><i class="fas fa-trash-alt"></i></button>
                    </div>
                `;
                list.appendChild(row);
            });
        }

        async function deleteKegiatan(id) {
            const result = await Swal.fire({
                title: 'Hapus kegiatan ini?', text: 'Data yang sudah dihapus tidak dapat dikembalikan.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#b3462c', cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
            });
            if (!result.isConfirmed) return;
            try {
                await apiFetch(routes.kegiatanDestroy(id), { method: 'DELETE' });
                await fetchKegiatan();
                renderKegiatanList();
                renderReminders();
                renderRecentActivity();
            } catch (err) {
                Swal.fire('Gagal menghapus', err.message, 'error');
            }
        }

        function exportKegiatanCSV() {
            const data = loadKegiatan();
            if (data.length === 0) { Swal.fire('Tidak ada data', 'Belum ada kegiatan untuk diekspor.', 'info'); return; }
            let csv = 'Tanggal,Lahan,Jenis,Petugas,Tindak Lanjut,Catatan\n';
            data.forEach(k => { csv += `${k.tanggal},"${(k.lahan_nama||'').replace(/"/g,'""')}",${k.jenis},"${(k.petugas||'').replace(/"/g,'""')}",${k.tindaklanjut||''},"${(k.catatan||'').replace(/"/g,'""')}"\n`; });
            downloadCsv(csv, `riwayat-kegiatan-${new Date().toISOString().slice(0,10)}.csv`);
        }

        // ---------- Produksi ----------
        let editingProduksiId = null;

        async function submitProduksi(e) {
            e.preventDefault();
            const lahanSelect = document.getElementById('p_lahan');
            const jumlahVal = parseFloat(document.getElementById('p_jumlah').value);
            if (isNaN(jumlahVal) || jumlahVal <= 0) {
                Swal.fire('Jumlah tidak valid', 'Masukkan jumlah produksi lebih besar dari 0.', 'error');
                return false;
            }
            const payload = {
                forest_land_id: lahanSelect.value,
                komoditas: document.getElementById('p_komoditas').value,
                jumlah: jumlahVal,
                satuan: document.getElementById('p_satuan').value,
                tanggal: document.getElementById('p_tanggal').value,
                catatan: document.getElementById('p_catatan').value || null
            };

            try {
                if (editingProduksiId) {
                    await apiFetch(routes.produksiUpdate(editingProduksiId), { method: 'PUT', body: JSON.stringify(payload) });
                    cancelEditProduksi(false);
                    Swal.fire({ icon: 'success', title: 'Produksi diperbarui', timer: 1400, showConfirmButton: false });
                } else {
                    await apiFetch(routes.produksiStore, { method: 'POST', body: JSON.stringify(payload) });
                    Swal.fire({ icon: 'success', title: 'Produksi tercatat', timer: 1400, showConfirmButton: false });
                }
                document.getElementById('produksiForm').reset();
                const todayIso = new Date().toISOString().slice(0, 10);
                const pTanggal = document.getElementById('p_tanggal'); if (pTanggal) pTanggal.value = todayIso;
                await fetchProduksi();
                renderProduksiAll();
            } catch (err) {
                Swal.fire('Gagal menyimpan', err.message, 'error');
            }
            return false;
        }

        function editProduksi(id) {
            const p = loadProduksi().find(x => String(x.id) === String(id));
            if (!p) return;
            populateLahanSelects();
            document.getElementById('p_lahan').value = p.lahan_id;
            document.getElementById('p_komoditas').value = p.komoditas;
            document.getElementById('p_jumlah').value = p.jumlah;
            document.getElementById('p_satuan').value = p.satuan;
            document.getElementById('p_tanggal').value = p.tanggal;
            document.getElementById('p_catatan').value = p.catatan || '';
            editingProduksiId = id;
            const btn = document.getElementById('produksiSubmitBtn');
            if (btn) btn.innerHTML = '<i class="fas fa-rotate"></i><span>Perbarui Produksi</span>';
            document.getElementById('produksiCancelBtn')?.classList.remove('hidden');
            document.getElementById('produksiForm')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function cancelEditProduksi(doReset = true) {
            editingProduksiId = null;
            const btn = document.getElementById('produksiSubmitBtn');
            if (btn) btn.innerHTML = '<i class="fas fa-save"></i><span>Simpan Produksi</span>';
            document.getElementById('produksiCancelBtn')?.classList.add('hidden');
            if (doReset) {
                document.getElementById('produksiForm')?.reset();
                const todayIso = new Date().toISOString().slice(0, 10);
                const pTanggal = document.getElementById('p_tanggal'); if (pTanggal) pTanggal.value = todayIso;
            }
        }

        async function deleteProduksi(id) {
            const result = await Swal.fire({
                title: 'Hapus data produksi ini?', text: 'Data yang sudah dihapus tidak dapat dikembalikan.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#b3462c', cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
            });
            if (!result.isConfirmed) return;
            try {
                await apiFetch(routes.produksiDestroy(id), { method: 'DELETE' });
                await fetchProduksi();
                renderProduksiAll();
            } catch (err) {
                Swal.fire('Gagal menghapus', err.message, 'error');
            }
        }

        function renderProduksiAll() {
            const data = loadProduksi().sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
            const tbody = document.getElementById('produksiTableBody');
            const empty = document.getElementById('produksiEmpty');
            if (tbody) {
                tbody.innerHTML = '';
                empty.classList.toggle('hidden', data.length > 0);
                data.forEach(p => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50 transition';
                    tr.innerHTML = `
                        <td class="td-cell font-mono text-sm text-gray-600">${formatTanggal(p.tanggal)}</td>
                        <td class="td-cell text-sm text-gray-800">${escapeHtml(p.lahan_nama)}</td>
                        <td class="td-cell text-sm text-gray-800">${escapeHtml(p.komoditas)}</td>
                        <td class="td-cell font-mono font-bold text-bark-600">${p.jumlah} ${satuanLabel(p.satuan)}</td>
                        <td class="td-cell no-print">
                            <div class="flex items-center gap-2">
                                <button onclick="editProduksi('${p.id}')" class="action-btn bg-resin-500 hover:bg-resin-600" aria-label="Edit produksi"><i class="fas fa-pen"></i></button>
                                <button onclick="deleteProduksi('${p.id}')" class="action-btn bg-clay-500 hover:bg-clay-600" aria-label="Hapus produksi"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            let sumKayu = 0, sumGetah = 0;
            data.forEach(p => {
                if (p.satuan === 'm3') sumKayu += p.jumlah;
                else if (p.satuan === 'kg') sumGetah += p.jumlah;
            });
            const elKayu = document.getElementById('sumKayu'); if (elKayu) elKayu.textContent = sumKayu.toFixed(1);
            const elGetah = document.getElementById('sumGetah'); if (elGetah) elGetah.textContent = sumGetah.toFixed(1);
            const elEntri = document.getElementById('sumEntri'); if (elEntri) elEntri.textContent = data.length;

            renderProduksiChart(data);
        }

        function satuanLabel(s) { return { m3: 'm\u00b3', kg: 'kg', batang: 'btg', liter: 'L' }[s] || s; }

        let produksiChart;
        function renderProduksiChart(data) {
            const canvas = document.getElementById('produksiChart');
            if (!canvas) return;
            const byMonth = {};
            data.forEach(p => {
                if (!p.tanggal) return;
                const ym = p.tanggal.slice(0, 7);
                byMonth[ym] = (byMonth[ym] || 0) + (parseFloat(p.jumlah) || 0);
            });
            const labels = Object.keys(byMonth).sort();
            const values = labels.map(l => byMonth[l]);

            if (produksiChart) { produksiChart.destroy(); produksiChart = null; }

            if (typeof Chart === 'undefined') {
                console.error('Chart.js belum termuat, cek koneksi ke CDN.');
                return;
            }

            // Tunda satu frame agar canvas sudah punya ukuran final (mengatasi
            // canvas yang masih 0px saat baru pindah tab / baru jadi terlihat).
            requestAnimationFrame(() => {
                produksiChart = new Chart(canvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels.length ? labels : ['Belum ada data'],
                        datasets: [{
                            label: 'Total Jumlah Produksi',
                            data: values.length ? values : [0],
                            backgroundColor: '#4a7343',
                            borderRadius: 6,
                            maxBarThickness: 48
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            });
        }

        // ================= Dashboard: reminders & recent activity =================
        function renderReminders() {
            const list = document.getElementById('reminderList');
            if (!list) return;
            const today = new Date(); today.setHours(0,0,0,0);
            const items = loadKegiatan().filter(k => k.tindaklanjut).map(k => ({ ...k, due: new Date(k.tindaklanjut) })).sort((a, b) => a.due - b.due);

            list.innerHTML = '';
            if (items.length === 0) {
                list.innerHTML = '<div class="p-6 text-center text-sm text-gray-400"><i class="fas fa-circle-check text-2xl mb-2 block text-canopy-300"></i>Tidak ada tindak lanjut terjadwal.</div>';
            }
            items.slice(0, 8).forEach(k => {
                const overdue = k.due < today;
                const soon = !overdue && (k.due - today) / 86400000 <= 7;
                const badgeClass = overdue ? 'bg-clay-100 text-clay-600' : soon ? 'bg-resin-100 text-resin-700' : 'bg-canopy-100 text-canopy-700';
                const badgeText = overdue ? 'Terlambat' : soon ? 'Segera' : 'Terjadwal';
                const row = document.createElement('div');
                row.className = 'p-4 flex items-center justify-between gap-3';
                row.innerHTML = `
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">${escapeHtml(k.lahan_nama)}</p>
                        <p class="text-xs text-gray-500">${escapeHtml(k.jenis)} &middot; jatuh tempo ${formatTanggal(k.tindaklanjut)}</p>
                    </div>
                    <span class="text-[11px] px-2 py-1 rounded-full font-semibold shrink-0 ${badgeClass}">${badgeText}</span>
                `;
                list.appendChild(row);
            });
            const kpi = document.getElementById('kpiPengingat');
            if (kpi) kpi.textContent = items.filter(k => k.due <= today || (k.due - today)/86400000 <= 7).length;
        }

        function renderRecentActivity() {
            const list = document.getElementById('recentActivityList');
            if (!list) return;
            const data = loadKegiatan().sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal)).slice(0, 8);
            list.innerHTML = '';
            if (data.length === 0) {
                list.innerHTML = '<div class="p-6 text-center text-sm text-gray-400"><i class="fas fa-inbox text-2xl mb-2 block text-gray-300"></i>Belum ada aktivitas tercatat.</div>';
                return;
            }
            data.forEach(k => {
                const icon = kegiatanIconMap[k.jenis] || 'fa-note-sticky';
                const color = kegiatanColorMap[k.jenis] || 'canopy';
                const row = document.createElement('div');
                row.className = 'p-4 flex items-center gap-3';
                row.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-${color}-100 flex items-center justify-center shrink-0"><i class="fas ${icon} text-${color}-700 text-xs"></i></div>
                    <div class="min-w-0">
                        <p class="text-sm text-gray-800 truncate"><span class="font-semibold">${escapeHtml(k.jenis)}</span> &middot; ${escapeHtml(k.lahan_nama)}</p>
                        <p class="text-xs text-gray-400 font-mono">${formatTanggal(k.tanggal)} &middot; ${escapeHtml(k.petugas)}</p>
                    </div>
                `;
                list.appendChild(row);
            });
        }

        function updateDashboardKpis() {
            const totalLuas = landsData.reduce((s, l) => s + parseFloat(l.luas_hektar), 0);
            const konservasiLuas = landsData.filter(l => l.status === 'Konservasi').reduce((s, l) => s + parseFloat(l.luas_hektar), 0);
            const pct = totalLuas > 0 ? (konservasiLuas / totalLuas) * 100 : 0;
            const el = document.getElementById('kpiKonservasi');
            if (el) { el.textContent = pct.toFixed(1) + '%'; el.className = 'stat-value ' + (pct >= 30 ? 'text-canopy-700' : 'text-clay-500'); }
        }

        // ================= Helpers =================
        function formatTanggal(iso) {
            if (!iso) return '-';
            const d = new Date(iso + 'T00:00:00');
            if (isNaN(d)) return iso;
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }
        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>"']/g, m => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[m]));
        }

        // ================= Charts (Analisis) =================
        let pieChart, barChart, donutChart, topChart, sizeChart;

        function initCharts() {
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

            // Palet hijau bertingkat: hijau tua (Konservasi), hijau moss (Produksi), hijau lime (Reboisasi)
            const palette = ['#2f6349', '#4a7343', '#6f8f28'];

            const pieCtx = document.getElementById('pieChart').getContext('2d');
            if (pieChart) pieChart.destroy();
            pieChart = new Chart(pieCtx, { type: 'pie', data: { labels: ['Konservasi', 'Produksi', 'Reboisasi'], datasets: [{ data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi], backgroundColor: palette, borderWidth: 2, borderColor: '#fff' }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } } });

            const barCtx = document.getElementById('barChart').getContext('2d');
            if (barChart) barChart.destroy();
            barChart = new Chart(barCtx, { type: 'bar', data: { labels: ['Konservasi', 'Produksi', 'Reboisasi'], datasets: [{ label: 'Total Luas (Ha)', data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi], backgroundColor: palette, borderRadius: 6 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } } });

            const donutCtx = document.getElementById('donutChart').getContext('2d');
            if (donutChart) donutChart.destroy();
            donutChart = new Chart(donutCtx, { type: 'doughnut', data: { labels: ['Konservasi', 'Produksi', 'Reboisasi'], datasets: [{ data: [statusCount.Konservasi, statusCount.Produksi, statusCount.Reboisasi], backgroundColor: palette, borderWidth: 2, borderColor: '#fff' }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, cutout: '60%' } });

            const topFive = [...landsData].sort((a, b) => parseFloat(b.luas_hektar) - parseFloat(a.luas_hektar)).slice(0, 5);
            const topCtx = document.getElementById('topChart').getContext('2d');
            if (topChart) topChart.destroy();
            topChart = new Chart(topCtx, { type: 'bar', data: { labels: topFive.map(l => l.nama_lahan), datasets: [{ label: 'Luas (Ha)', data: topFive.map(l => parseFloat(l.luas_hektar)), backgroundColor: '#6f8f28', borderRadius: 6 }] }, options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } } });

            const sizeBuckets = { Kecil: 0, Sedang: 0, Besar: 0 };
            landsData.forEach(l => { const luas = parseFloat(l.luas_hektar); if (luas < 10) sizeBuckets.Kecil++; else if (luas <= 50) sizeBuckets.Sedang++; else sizeBuckets.Besar++; });
            const sizeCtx = document.getElementById('sizeChart').getContext('2d');
            if (sizeChart) sizeChart.destroy();
            sizeChart = new Chart(sizeCtx, { type: 'bar', data: { labels: ['Kecil (< 10 Ha)', 'Sedang (10-50 Ha)', 'Besar (> 50 Ha)'], datasets: [{ label: 'Jumlah Lahan', data: [sizeBuckets.Kecil, sizeBuckets.Sedang, sizeBuckets.Besar], backgroundColor: ['#d8e3d7', '#7ea888', '#2f6349'], borderRadius: 6 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } } });

            renderSummaryTable(statusLuas, statusCount, totalLuas);
            renderConservationRatio(statusLuas, totalLuas);
            renderInsights(statusLuas, statusCount, totalLuas, totalCount);
        }

        function renderSummaryTable(statusLuas, statusCount, totalLuas) {
            const body = document.getElementById('summaryTableBody');
            if (!body) return;
            body.innerHTML = '';
            ['Konservasi', 'Produksi', 'Reboisasi'].forEach(status => {
                const jumlah = statusCount[status] || 0;
                const luas = statusLuas[status] || 0;
                const rata = jumlah > 0 ? luas / jumlah : 0;
                const pct = totalLuas > 0 ? (luas / totalLuas) * 100 : 0;
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 transition';
                tr.innerHTML = `
                    <td class="td-cell"><span class="status-badge status-${status}">${status}</span></td>
                    <td class="td-cell font-semibold text-gray-700">${jumlah}</td>
                    <td class="td-cell font-mono font-bold text-canopy-700">${luas.toFixed(2)}</td>
                    <td class="td-cell text-gray-600">${rata.toFixed(2)}</td>
                    <td class="td-cell text-gray-600">${pct.toFixed(1)}%</td>
                `;
                body.appendChild(tr);
            });
        }

        function renderConservationRatio(statusLuas, totalLuas) {
            const target = 30;
            const pct = totalLuas > 0 ? (statusLuas.Konservasi / totalLuas) * 100 : 0;
            const circumference = 2 * Math.PI * 70;
            const progress = Math.min(pct, 100) / 100 * circumference;
            const ringProgress = document.getElementById('ringProgress');
            const ringTarget = document.getElementById('ringTarget');
            if (ringProgress) {
                ringProgress.setAttribute('stroke-dasharray', `${progress} ${circumference}`);
                ringProgress.setAttribute('stroke', pct >= target ? '#2f6349' : '#6f8f28');
            }
            if (ringTarget) {
                const targetLen = target / 100 * circumference;
                ringTarget.setAttribute('stroke-dasharray', `1 ${targetLen - 1} 1 ${circumference - targetLen}`);
            }
            const pctLabel = document.getElementById('ringPct');
            if (pctLabel) pctLabel.textContent = pct.toFixed(1) + '%';

            const note = document.getElementById('conservationNote');
            if (!note) return;
            if (totalLuas === 0) note.textContent = 'Belum ada data lahan untuk dihitung.';
            else if (pct >= target) note.innerHTML = `<i class="fas fa-circle-check text-canopy-600 mr-1"></i> Kawasan konservasi sudah memenuhi acuan minimum ${target}%.`;
            else { const kurang = (target - pct) / 100 * totalLuas; note.innerHTML = `<i class="fas fa-triangle-exclamation text-resin-600 mr-1"></i> Masih kurang sekitar <b>${kurang.toFixed(2)} Ha</b> untuk mencapai acuan minimum ${target}%.`; }
        }

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

            if (totalCount === 0) { addInsight('fa-circle-info', 'text-gray-400', 'Belum ada data lahan yang bisa dianalisis. Tambahkan data lahan terlebih dahulu.'); return; }

            const dominantByLuas = Object.entries(statusLuas).sort((a, b) => b[1] - a[1])[0];
            const dominantPct = totalLuas > 0 ? (dominantByLuas[1] / totalLuas) * 100 : 0;
            addInsight('fa-chart-pie', 'text-canopy-600', `Status <b>${escapeHtml(dominantByLuas[0])}</b> mendominasi dengan <b>${dominantPct.toFixed(1)}%</b> dari total luas lahan (${dominantByLuas[1].toFixed(2)} Ha).`);

            const sorted = [...landsData].sort((a, b) => parseFloat(b.luas_hektar) - parseFloat(a.luas_hektar));
            const largest = sorted[0];
            const smallest = sorted[sorted.length - 1];
            addInsight('fa-ranking-star', 'text-resin-600', `Lahan terluas adalah <b>${escapeHtml(largest.nama_lahan)}</b> (${parseFloat(largest.luas_hektar).toFixed(2)} Ha), sedangkan terkecil <b>${escapeHtml(smallest.nama_lahan)}</b> (${parseFloat(smallest.luas_hektar).toFixed(2)} Ha).`);

            const avg = totalLuas / totalCount;
            addInsight('fa-balance-scale', 'text-bark-600', `Rata-rata luas per lahan saat ini adalah <b>${avg.toFixed(2)} Ha</b> dari total ${totalCount} blok terdaftar.`);

            const konservasiPct = totalLuas > 0 ? (statusLuas.Konservasi / totalLuas) * 100 : 0;
            if (konservasiPct < 30) addInsight('fa-triangle-exclamation', 'text-resin-600', `Proporsi kawasan konservasi baru <b>${konservasiPct.toFixed(1)}%</b>, masih di bawah acuan minimum kebijakan sebesar 30%.`);
            else addInsight('fa-circle-check', 'text-canopy-600', `Proporsi kawasan konservasi <b>${konservasiPct.toFixed(1)}%</b> sudah memenuhi acuan minimum kebijakan sebesar 30%.`);

            const pengingatAktif = loadKegiatan().filter(k => k.tindaklanjut).length;
            if (pengingatAktif > 0) addInsight('fa-bell', 'text-clay-500', `Terdapat <b>${pengingatAktif}</b> jadwal tindak lanjut kegiatan yang perlu dipantau pada menu Kegiatan Lahan.`);
        }

        function downloadChart(canvasId, filename) {
            const chartMap = { pieChart, barChart, donutChart, topChart, sizeChart, produksiChart };
            const chartInstance = chartMap[canvasId];
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const url = chartInstance ? chartInstance.toBase64Image() : canvas.toDataURL('image/png');
            const a = document.createElement('a');
            a.href = url; a.download = `${filename}.png`;
            document.body.appendChild(a); a.click(); document.body.removeChild(a);
        }

        function exportProduksiCSV() {
            const data = loadProduksi();
            if (data.length === 0) { Swal.fire('Tidak ada data', 'Belum ada data produksi untuk diekspor.', 'info'); return; }
            let csv = 'Tanggal,Lahan,Komoditas,Jumlah,Satuan,Catatan\n';
            data.forEach(p => { csv += `${p.tanggal},"${(p.lahan_nama||'').replace(/"/g,'""')}","${p.komoditas}",${p.jumlah},${p.satuan},"${(p.catatan||'').replace(/"/g,'""')}"\n`; });
            downloadCsv(csv, `riwayat-produksi-${new Date().toISOString().slice(0,10)}.csv`);
        }

        // ================= Wiring =================
        document.getElementById('searchInput')?.addEventListener('input', () => { currentPage = 1; applyFilters(); });
        document.getElementById('statusFilter')?.addEventListener('change', () => { chipFilter = 'all'; document.querySelectorAll('.chip-btn').forEach(b => b.classList.remove('chip-active')); document.querySelector('.chip-btn[data-chip="all"]')?.classList.add('chip-active'); currentPage = 1; applyFilters(); });
        document.getElementById('sizeFilter')?.addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('perPage')?.addEventListener('change', () => { currentPage = 1; applyFilters(); });

        document.addEventListener('keydown', (e) => {
            if (e.key === '/' && document.activeElement.tagName !== 'INPUT') { e.preventDefault(); document.getElementById('searchInput')?.focus(); }
        });

        window.addEventListener('DOMContentLoaded', async () => {
            document.getElementById('tab-dashboard')?.classList.add('active-tab');
            document.getElementById('mtab-dashboard')?.classList.add('active-tab');
            document.querySelector('.chip-btn[data-chip="all"]')?.classList.add('chip-active');

            const todayIso = new Date().toISOString().slice(0, 10);
            const kTanggal = document.getElementById('k_tanggal'); if (kTanggal) kTanggal.value = todayIso;
            const pTanggal = document.getElementById('p_tanggal'); if (pTanggal) pTanggal.value = todayIso;

            applyFilters();
            updateDashboardKpis();

            await fetchKegiatan();
            renderReminders();
            renderRecentActivity();
        });
    </script>
</body>
</html>