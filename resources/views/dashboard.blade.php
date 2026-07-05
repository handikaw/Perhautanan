<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SaaS Manajemen Perhutanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 min-h-screen">

    <nav class="bg-white shadow-lg border-b-4 border-emerald-500 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3 cursor-pointer" onclick="switchPage('dashboard')">
                    <div class="bg-emerald-600 p-2 rounded-lg">
                        <i class="fas fa-tree text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-emerald-800">Perhutani</h1>
                        <p class="text-xs text-gray-500">Monitoring Lahan & Hasil Hutan</p>
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

                <button 
                    id="mobileMenuBtn" 
                    class="md:hidden p-2 rounded-lg text-emerald-600 hover:bg-emerald-50 transition"
                    onclick="toggleMobileMenu()"
                >
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

    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg border-b-2 border-emerald-500">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-2">
            <button onclick="switchPage('dashboard'); toggleMobileMenu();" class="w-full text-left bg-emerald-50 text-emerald-800 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2">
                <i class="fas fa-home w-5"></i> <span>Dashboard Utama</span>
            </button>
            <button onclick="switchPage('tambah-lahan'); toggleMobileMenu();" class="w-full text-left text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2">
                <i class="fas fa-plus-circle w-5"></i> <span>Tambah Lahan Baru</span>
            </button>
            <button onclick="switchPage('analisis'); toggleMobileMenu();" class="w-full text-left text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg font-medium flex items-center space-x-2">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-start space-x-3 animate-fade-in">
                <i class="fas fa-check-circle text-2xl mt-1"></i>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <section id="page-dashboard" class="page-section space-y-8">
            <div>
                <h2 class="text-3xl font-bold text-emerald-900 mb-2">Dashboard Lahan Perhutanan</h2>
                <p class="text-gray-600">Kelola dan pantau data lahan hutan Anda secara real-time</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500 hover:shadow-xl transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Lahan</p>
                            <p class="text-4xl font-bold text-emerald-700 mt-2">{{ $forestLands->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">Blok hutan terdaftar</p>
                        </div>
                        <div class="bg-emerald-100 p-4 rounded-full"><i class="fas fa-layer-group text-emerald-600 text-3xl"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500 hover:shadow-xl transition duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Luas</p>
                            <p class="text-4xl font-bold text-green-700 mt-2">{{ number_format($forestLands->sum('luas_hektar'), 2) }}</p>
                            <p class="text-xs text-gray-400 mt-1">Hektar (Ha)</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-full"><i class="fas fa-chart-area text-green-600 text-3xl"></i></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-teal-500 hover:shadow-xl transition duration-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Status Aktif</p>
            <p class="text-4xl font-bold text-teal-700 mt-2">
                {{ $forestLands->count() > 0 ? $forestLands->countBy('status')->sortDesc()->keys()->first() : '-' }}
            </p>
            <p class="text-xs text-gray-400 mt-1">Status dominan</p>
        </div>
        <div class="bg-teal-100 p-4 rounded-full"><i class="fas fa-seedling text-teal-600 text-3xl"></i></div>
    </div>
</div>
</div>

<div class="bg-white rounded-xl shadow-lg p-6">
<div class="flex items-center justify-between mb-4">
    <h3 class="text-lg font-bold text-emerald-900 flex items-center">
                    </h3>
                    <button onclick="resetFilters()" class="text-sm text-gray-600 hover:text-emerald-600 transition flex items-center">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fas fa-search mr-1"></i> Cari Nama Lahan</label>
                        <input type="text" id="searchInput" placeholder="Ketik nama lahan..." class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition">
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
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                            <i class="fas fa-table"></i> <span>Daftar Lahan Perhutanan</span>
                        </h3>
                    </div>
                    <button onclick="switchPage('tambah-lahan')" class="bg-white text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg font-semibold text-xs shadow transition flex items-center space-x-1">
                        <i class="fas fa-plus"></i> <span>Tambah Lahan</span>
                    </button>
                </div>

                @if($forestLands->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lahan</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Luas (Ha)</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                                @foreach($forestLands as $index => $land)
                                    <tr class="land-row hover:bg-emerald-50 transition duration-150" 
                                        data-name="{{ strtolower($land->nama_lahan) }}"
                                        data-status="{{ $land->status }}"
                                        data-luas="{{ $land->luas_hektar }}">
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-bold text-gray-700">{{ $index + 1 }}</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $land->nama_lahan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-emerald-700">{{ number_format($land->luas_hektar, 2) }} Ha</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $land->status == 'Produksi' ? 'bg-blue-100 text-blue-800' : ($land->status == 'Konservasi' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $land->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('forest.edit', $land->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold shadow-sm"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('forest.destroy', $land->id) }}" method="POST" onsubmit="return confirm('Hapus lahan ini?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold shadow-sm"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-500">Belum ada data lahan.</p>
                    </div>
                @endif
            </div>
        </section>


        <section id="page-tambah-lahan" class="page-section id-page hidden space-y-6">
            <div class="flex items-center space-x-3 mb-2">
                <button onclick="switchPage('dashboard')" class="p-2 bg-white rounded-lg shadow border border-gray-200 text-emerald-700 hover:bg-gray-50"><i class="fas fa-arrow-left"></i></button>
                <div>
                    <h2 class="text-3xl font-bold text-emerald-900">Tambah Lahan Baru</h2>
                    <p class="text-gray-600">Daftarkan blok lahan komoditas perhutanan baru ke dalam sistem</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 p-6 max-w-2xl">
                <form method="POST" action="{{ route('forest.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lahan / Blok Hutan</label>
                        <input type="text" name="nama_lahan" required placeholder="Contoh: Blok RPH Mangunan A1" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Luas Lahan (Hektar)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="luas_hektar" required placeholder="0.00" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                <span class="absolute right-4 top-3 text-sm text-gray-400 font-bold">Ha</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pemanfaatan</label>
                            <select name="status" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                <option value="Konservasi">Konservasi</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Reboisasi">Reboisasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <button type="button" onclick="switchPage('dashboard')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg font-medium transition">Batal</button>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-md transition flex items-center space-x-2">
                            <i class="fas fa-save"></i> <span>Simpan Data Lahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>


        <section id="page-analisis" class="page-section hidden space-y-6">
            <div>
                <h2 class="text-3xl font-bold text-emerald-900 mb-2">Analisis Visual Data Lahan</h2>
                <p class="text-gray-600">Distribusi kalkulasi luas lahan terdaftar berdasarkan parameter status wilayah</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500">
                    <h4 class="text-lg font-bold text-emerald-900 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-emerald-600 mr-2"></i> Proporsi Distribusi Lahan (Ha)
                    </h4>
                    <div class="relative" style="height: 320px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-emerald-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Akumulasi Total: <span id="pieTotal" class="font-bold text-emerald-700">0</span> Ha</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500">
                    <h4 class="text-lg font-bold text-emerald-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-green-600 mr-2"></i> Perbandingan Luas Berdasarkan Status Pemanfaatan
                    </h4>
                    <div class="relative" style="height: 320px;">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="mt-4 text-center bg-green-50 p-2 rounded-lg">
                        <p class="text-sm text-gray-600">Akumulasi Total: <span id="barTotal" class="font-bold text-green-700">0</span> Ha</p>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-section:not(.hidden) {
            animation: fade-in 0.4s ease-out forwards;
        }
    </style>

    <script>
        function switchPage(pageId) {
            // Sembunyikan semua section halaman
            document.querySelectorAll('.page-section').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Tampilkan halaman terpilih
            document.getElementById(`page-${pageId}`).classList.remove('hidden');

            // Reset style seluruh tombol tab desktop
            const tabs = ['dashboard', 'tambah-lahan', 'analisis'];
            tabs.forEach(tab => {
                const button = document.getElementById(`tab-${tab}`);
                if (button) {
                    button.className = "px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 text-gray-600 hover:bg-gray-200";
                }
            });

            // Beri highlight aktif pada tab yang dipilih
            const activeTab = document.getElementById(`tab-${pageId}`);
            if (activeTab) {
                activeTab.className = "px-4 py-2 rounded-lg text-sm font-medium transition duration-150 flex items-center space-x-2 bg-emerald-600 text-white shadow";
            }

            // Render ulang Chart jika berpindah ke tab analisis data
            if(pageId === 'analisis') {
                initCharts(filteredData);
            }
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>

    <script>
        const landsData = @json($forestLands);
        let filteredData = [...landsData];
        let pieChart, barChart;
        
        function initCharts(data) {
            const statusLuas = { 'Konservasi': 0, 'Produksi': 0, 'Reboisasi': 0 };
            
            data.forEach(land => {
                if (statusLuas[land.status] !== undefined) {
                    statusLuas[land.status] += parseFloat(land.luas_hektar);
                }
            });
            
            const totalLuas = statusLuas.Konservasi + statusLuas.Produksi + statusLuas.Reboisasi;
            
            if(document.getElementById('pieTotal')) document.getElementById('pieTotal').textContent = totalLuas.toFixed(2);
            if(document.getElementById('barTotal')) document.getElementById('barTotal').textContent = totalLuas.toFixed(2);
            
            // Render Pie Chart
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            if (pieChart) pieChart.destroy();
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{
                        data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });
            
            // Render Bar Chart
            const barCtx = document.getElementById('barChart').getContext('2d');
            if (barChart) barChart.destroy();
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{
                        label: 'Total Luas (Ha)',
                        data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b'],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }
        
        // Logical filter untuk Live-Search Tabel Lahan
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const sizeFilter = document.getElementById('sizeFilter').value;
            
            const rows = document.querySelectorAll('.land-row');
            let visibleCount = 0;

            filteredData = landsData.filter((land, index) => {
                const row = rows[index];
                if(!row) return false;

                const matchSearch = land.nama_lahan.toLowerCase().includes(searchTerm);
                const matchStatus = statusFilter === 'all' || land.status === statusFilter;
                
                let matchSize = true;
                const luas = parseFloat(land.luas_hektar);
                if (sizeFilter === 'small') matchSize = luas < 10;
                else if (sizeFilter === 'medium') matchSize = luas >= 10 && luas <= 50;
                else if (sizeFilter === 'large') matchSize = luas > 50;
                
                const isVisible = matchSearch && matchStatus && matchSize;
                
                if (isVisible) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
                
                return isVisible;
            });
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('sizeFilter').value = 'all';
            applyFilters();
        }

        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('sizeFilter').addEventListener('change', applyFilters);

        // Inisialisasi awal saat dokumen siap
        window.addEventListener('DOMContentLoaded', () => {
            initCharts(landsData);
        });
    </script>
</body>
</html>