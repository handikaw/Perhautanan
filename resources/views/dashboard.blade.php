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

    <!-- NAVBAR -->
    <nav class="bg-white shadow-lg border-b-4 border-emerald-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="bg-emerald-600 p-2 rounded-lg">
                        <i class="fas fa-tree text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-emerald-800">Perhutani</h1>
                        <p class="text-xs text-gray-500">Monitoring Lahan & Hasil Hutan</p>
                    </div>
                </div>
                
                <!-- Mobile menu button (hidden on desktop) -->
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
                    <a href="{{ route('forest.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200 shadow-md hover:shadow-lg flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Lahan</span>
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

    <!-- Mobile Menu Dropdown (hidden by default) -->
    <div id="mobileMenu" class="hidden md:hidden bg-white shadow-lg border-b-2 border-emerald-500">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-3">
            
            <!-- Tambah Lahan Button -->
            <a href="{{ route('forest.create') }}" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-lg font-medium transition duration-200 text-center">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Lahan
            </a>
            
            <!-- Profile Section -->
            <div class="border-t border-gray-200 pt-3">
                <div class="flex items-center space-x-3 px-4 py-2">
                    @if(Auth::check() && Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-12 w-12 rounded-full object-cover border-2 border-emerald-500">
                    @else
                        <i class="fas fa-user-circle text-4xl text-emerald-600"></i>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-900">{{ Auth::check() ? Auth::user()->name : 'Admin User' }}</span>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-emerald-600 hover:text-emerald-800 transition">
                            <i class="fas fa-edit mr-1"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-200 pt-3">
                @csrf
                <button type="submit" class="block w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg font-medium transition duration-200 text-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Logout
                </button>
            </form>
            
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- HEADER SECTION -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-emerald-900 mb-2">Dashboard Lahan Perhutanan</h2>
            <p class="text-gray-600">Kelola dan pantau data lahan hutan Anda secara real-time</p>
        </div>

        <!-- ALERT SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-start space-x-3 animate-fade-in">
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

        <!-- STATISTICS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Total Lahan -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500 hover:shadow-xl transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Lahan</p>
                        <p class="text-4xl font-bold text-emerald-700 mt-2">{{ $forestLands->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">Blok hutan terdaftar</p>
                    </div>
                    <div class="bg-emerald-100 p-4 rounded-full">
                        <i class="fas fa-layer-group text-emerald-600 text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Luas -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500 hover:shadow-xl transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Luas</p>
                        <p class="text-4xl font-bold text-green-700 mt-2">{{ number_format($forestLands->sum('luas_hektar'), 2) }}</p>
                        <p class="text-xs text-gray-400 mt-1">Hektar (Ha)</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-chart-area text-green-600 text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Card 3: Status Terbanyak -->
            <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-teal-500 hover:shadow-xl transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Status Aktif</p>
                        <p class="text-4xl font-bold text-teal-700 mt-2">
                            @if($forestLands->count() > 0)
                                {{ $forestLands->groupBy('status')->sortByDesc(function($group) { return $group->count(); })->keys()->first() ?? '-' }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Status dominan</p>
                    </div>
                    <div class="bg-teal-100 p-4 rounded-full">
                        <i class="fas fa-seedling text-teal-600 text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS ANALYTICS SECTION -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-emerald-900 mb-6 flex items-center">
                <i class="fas fa-chart-pie text-emerald-600 mr-2"></i>
                Analisis Data Lahan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Pie Chart Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-500 hover:shadow-xl transition duration-200">
                    <h4 class="text-lg font-bold text-emerald-900 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-emerald-600 mr-2"></i>
                        Distribusi Luas Lahan (Ha)
                    </h4>
                    <div class="relative" style="height: 300px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">Total Luas: <span id="pieTotal" class="font-bold text-emerald-700">0</span> Ha</p>
                    </div>
                </div>

                <!-- Bar Chart Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-500 hover:shadow-xl transition duration-200">
                    <h4 class="text-lg font-bold text-emerald-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                        Total Luas per Status
                    </h4>
                    <div class="relative" style="height: 300px;">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">Total Luas: <span id="barTotal" class="font-bold text-green-700">0</span> Ha</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- FILTER & SEARCH SECTION -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-emerald-900 flex items-center">
                    <i class="fas fa-filter text-emerald-600 mr-2"></i>
                    Filter & Pencarian Data
                </h3>
                <button onclick="resetFilters()" class="text-sm text-gray-600 hover:text-emerald-600 transition flex items-center">
                    <i class="fas fa-redo mr-1"></i>
                    Reset
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <!-- Search Box -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i> Cari Nama Lahan
                    </label>
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Ketik nama lahan..." 
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                    >
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-1"></i> Status Lahan
                    </label>
                    <select 
                        id="statusFilter" 
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                    >
                        <option value="all">Semua Status</option>
                        <option value="Konservasi">Konservasi</option>
                        <option value="Produksi">Produksi</option>
                        <option value="Reboisasi">Reboisasi</option>
                    </select>
                </div>
                
                <!-- Size Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-ruler-combined mr-1"></i> Ukuran Lahan
                    </label>
                    <select 
                        id="sizeFilter" 
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-emerald-500 focus:outline-none transition"
                    >
                        <option value="all">Semua Ukuran</option>
                        <option value="small">Kecil (&lt; 10 Ha)</option>
                        <option value="medium">Sedang (10-50 Ha)</option>
                        <option value="large">Besar (&gt; 50 Ha)</option>
                    </select>
                </div>
            </div>
            
            <!-- Filter Results Info -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div id="filterCount" class="text-sm text-gray-600">
                    Menampilkan <span class="font-bold text-emerald-700">0</span> dari <span class="font-bold text-gray-700">0</span> lahan
                </div>
                <div class="flex items-center space-x-2 text-xs text-gray-500">
                    <i class="fas fa-info-circle"></i>
                    <span>Filter otomatis saat Anda mengetik atau memilih</span>
                </div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-6 py-4 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-white flex items-center space-x-2">
                        <i class="fas fa-table"></i>
                        <span>Daftar Lahan Perhutanan</span>
                    </h3>
                    <p class="text-emerald-100 text-sm mt-1">Menampilkan {{ $forestLands->count() }} data lahan</p>
                </div>
                <div class="text-white">
                    <i class="fas fa-filter cursor-pointer hover:text-emerald-200"></i>
                </div>
            </div>

            <!-- Table Content -->
            @if($forestLands->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-1"></i> No
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-map-marked-alt mr-1"></i> Nama Lahan
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-ruler-combined mr-1"></i> Luas (Ha)
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-tag mr-1"></i> Status
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    <i class="fas fa-calendar-alt mr-1"></i> Tanggal Input
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($forestLands as $index => $land)
                                <tr class="land-row hover:bg-emerald-50 transition duration-150 cursor-pointer" 
                                    data-name="{{ strtolower($land->nama_lahan) }}"
                                    data-status="{{ $land->status }}"
                                    data-luas="{{ $land->luas_hektar }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                                <span class="text-emerald-700 font-bold">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $land->nama_lahan }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ $land->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ number_format($land->luas_hektar, 2) }}</div>
                                        <div class="text-xs text-gray-500">Hektar</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($land->status == 'Produksi')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-300">
                                                <i class="fas fa-industry mr-1"></i> Produksi
                                            </span>
                                        @elseif($land->status == 'Konservasi')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-300">
                                                <i class="fas fa-leaf mr-1"></i> Konservasi
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
                                                <i class="fas fa-tree mr-1"></i> Reboisasi
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="far fa-calendar mr-1"></i>
                                        {{ $land->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-400">{{ $land->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('forest.edit', $land->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs font-semibold transition duration-200 shadow-md hover:shadow-lg flex items-center space-x-1">
                                                <i class="fas fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                            <form action="{{ route('forest.destroy', $land->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lahan {{ $land->nama_lahan }}? Data yang dihapus tidak dapat dikembalikan!');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs font-semibold transition duration-200 shadow-md hover:shadow-lg flex items-center space-x-1">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold text-emerald-700">{{ $forestLands->count() }}</span> dari <span class="font-semibold text-emerald-700">{{ $forestLands->count() }}</span> total data
                    </div>
                </div>

            @else
                <!-- EMPTY STATE -->
                <div class="text-center py-16 px-6">
                    <div class="inline-block mb-6">
                        <div class="bg-emerald-100 p-8 rounded-full">
                            <i class="fas fa-folder-open text-emerald-600 text-6xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data Lahan</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Anda belum memiliki data lahan perhutanan. Mulai dengan menambahkan lahan pertama Anda untuk monitoring dan pengelolaan yang lebih baik.
                    </p>
                    <a href="{{ route('forest.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition duration-200">
                        <i class="fas fa-plus-circle text-xl"></i>
                        <span>Tambah Lahan Pertama</span>
                    </a>
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 max-w-3xl mx-auto text-left">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <i class="fas fa-industry text-blue-600 text-2xl mb-2"></i>
                            <h4 class="font-semibold text-blue-900 text-sm">Hutan Produksi</h4>
                            <p class="text-xs text-blue-700 mt-1">Lahan untuk hasil kayu dan produksi</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <i class="fas fa-leaf text-green-600 text-2xl mb-2"></i>
                            <h4 class="font-semibold text-green-900 text-sm">Hutan Konservasi</h4>
                            <p class="text-xs text-green-700 mt-1">Lahan untuk pelestarian alam</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <i class="fas fa-tree text-yellow-600 text-2xl mb-2"></i>
                            <h4 class="font-semibold text-yellow-900 text-sm">Zona Reboisasi</h4>
                            <p class="text-xs text-yellow-700 mt-1">Lahan untuk penanaman kembali</p>
                        </div>
                    </div>
                </div>
            @endif
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

    <script>
        const landsData = @json($forestLands);
        
        let pieChart, barChart;
        
        function initCharts(data) {
            const statusCounts = {
                'Konservasi': 0,
                'Produksi': 0,
                'Reboisasi': 0
            };
            const statusLuas = {
                'Konservasi': 0,
                'Produksi': 0,
                'Reboisasi': 0
            };
            
            data.forEach(land => {
                statusCounts[land.status]++;
                statusLuas[land.status] += parseFloat(land.luas_hektar);
            });
            
            const totalLuas = statusLuas.Konservasi + statusLuas.Produksi + statusLuas.Reboisasi;
            document.getElementById('pieTotal').textContent = totalLuas.toFixed(2);
            document.getElementById('barTotal').textContent = totalLuas.toFixed(2);
            
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            if (pieChart) pieChart.destroy();
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{
                        data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi],
                        backgroundColor: ['#22c55e', '#3b82f6', '#eab308'],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.toFixed(2) + ' Ha';
                                }
                            }
                        }
                    }
                }
            });
            
            const barCtx = document.getElementById('barChart').getContext('2d');
            if (barChart) barChart.destroy();
            barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Konservasi', 'Produksi', 'Reboisasi'],
                    datasets: [{
                        label: 'Total Luas (Ha)',
                        data: [statusLuas.Konservasi, statusLuas.Produksi, statusLuas.Reboisasi],
                        backgroundColor: ['#22c55e', '#3b82f6', '#eab308'],
                        borderWidth: 2,
                        borderColor: '#fff',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Luas: ' + context.parsed.y.toFixed(2) + ' Ha';
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(1) + ' Ha';
                                }
                            },
                            title: { 
                                display: true, 
                                text: 'Luas (Hektar)',
                                font: { weight: 'bold' }
                            }
                        },
                        x: {
                            ticks: {
                                font: { weight: 'bold' }
                            }
                        }
                    }
                }
            });
        }
        
        initCharts(landsData);
    </script>

    <script>
        let filteredData = [...landsData];
        
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => applyFilters(), 300);
        });
        
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('sizeFilter').addEventListener('change', applyFilters);
        
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const sizeFilter = document.getElementById('sizeFilter').value;
            
            filteredData = landsData.filter(land => {
                const matchSearch = land.nama_lahan.toLowerCase().includes(searchTerm);
                
                const matchStatus = statusFilter === 'all' || land.status === statusFilter;
                
                let matchSize = true;
                if (sizeFilter === 'small') matchSize = land.luas_hektar < 10;
                else if (sizeFilter === 'medium') matchSize = land.luas_hektar >= 10 && land.luas_hektar <= 50;
                else if (sizeFilter === 'large') matchSize = land.luas_hektar > 50;
                
                return matchSearch && matchStatus && matchSize;
            });
            
            updateDisplay();
        }
        
        function updateDisplay() {
            document.querySelectorAll('.land-row').forEach(row => {
                const name = row.dataset.name;
                const status = row.dataset.status;
                const luas = parseFloat(row.dataset.luas);
                
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value;
                const sizeFilter = document.getElementById('sizeFilter').value;
                
                let show = true;
                if (searchTerm && !name.includes(searchTerm)) show = false;
                if (statusFilter !== 'all' && status !== statusFilter) show = false;
                if (sizeFilter === 'small' && luas >= 10) show = false;
                if (sizeFilter === 'medium' && (luas < 10 || luas > 50)) show = false;
                if (sizeFilter === 'large' && luas <= 50) show = false;
                
                row.style.display = show ? '' : 'none';
            });
            
            const visibleCount = filteredData.length;
            const totalCount = landsData.length;
            document.getElementById('filterCount').innerHTML = 
                `Menampilkan <span class="font-bold text-emerald-700">${visibleCount}</span> dari <span class="font-bold text-gray-700">${totalCount}</span> lahan`;
            
            initCharts(filteredData);
        }
        
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('sizeFilter').value = 'all';
            filteredData = [...landsData];
            updateDisplay();
        }
        
        updateDisplay();
    </script>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
            }
        }
        
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            
            if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
