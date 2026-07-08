<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhutani &middot; Sistem Monitoring Lahan &amp; Hasil Hutan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        /* Palet buku lapangan hutan — sama dengan sistem dashboard: canopy = hijau
                           tajuk (utama), bark = coklat kulit kayu (netral/sekunder), resin = kuning
                           getah damar (aksen terbatas), clay = merah tanah liat (khusus penekanan),
                           mist = krem kertas lapangan, ink = tinta coklat-hitam. */
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
<body class="bg-mist font-body text-ink" style="background-image:radial-gradient(rgba(38,33,26,0.05) 1px, transparent 1px); background-size: 20px 20px;">

    <!-- ============ NAVBAR ============ -->
    <nav class="fixed w-full bg-canopy-900 border-b border-bark-500/40 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-18 py-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-resin-500/70 flex items-center justify-center">
                        <i class="fas fa-tree text-resin-500 text-base"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-display font-semibold text-white tracking-wide">Perhutani</h1>
                        <p class="text-[11px] text-canopy-300">Sistem Monitoring Lahan &amp; Hasil Hutan</p>
                    </div>
                </div>

                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#features" class="text-canopy-200 hover:text-white font-medium transition text-sm">Fitur</a>
                    <a href="#pricing" class="text-canopy-200 hover:text-white font-medium transition text-sm">Harga</a>
                    <a href="#faq" class="text-canopy-200 hover:text-white font-medium transition text-sm">FAQ</a>
                </div>

                <div class="hidden sm:flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-canopy-100 hover:text-white font-medium transition duration-200 px-4 py-2 text-sm">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-resin-500 hover:bg-resin-600 text-ink px-5 py-2.5 rounded-md font-semibold text-sm transition duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Gratis
                    </a>
                </div>

                <button id="mobileNavBtn" class="sm:hidden p-2 rounded-md text-canopy-100" onclick="document.getElementById('mobileNav').classList.toggle('hidden')" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobileNav" class="hidden sm:hidden bg-canopy-900 border-t border-bark-500/40">
            <div class="px-4 py-4 space-y-3">
                <a href="#features" class="block text-canopy-100 font-medium">Fitur</a>
                <a href="#pricing" class="block text-canopy-100 font-medium">Harga</a>
                <a href="#faq" class="block text-canopy-100 font-medium">FAQ</a>
                <a href="{{ route('login') }}" class="block text-canopy-100 font-medium pt-2 border-t border-canopy-700"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                <a href="{{ route('register') }}" class="block bg-resin-500 text-ink text-center px-4 py-2.5 rounded-md font-semibold"><i class="fas fa-user-plus mr-2"></i>Daftar Gratis</a>
            </div>
        </div>
    </nav>

    <!-- ============ HERO SECTION ============ -->
    <section class="pt-32 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center border border-bark-300 bg-white text-bark-600 px-3 py-1.5 rounded-md text-xs font-semibold uppercase tracking-wide mb-6">
                        <i class="fas fa-leaf mr-2 text-canopy-600"></i>Buku Catatan Lahan Digital
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-display font-semibold text-ink mb-6 leading-tight">
                        Kelola Lahan Hutan Anda dengan Lebih Rapi
                    </h1>
                    <p class="text-lg text-bark-600 mb-8 leading-relaxed">
                        Sistem pencatatan dan manajemen lahan perhutanan yang sederhana dan terpadu. Pantau hasil hutan, catat kegiatan lapangan, dan susun laporan tanpa ribet.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register') }}" class="btn-primary-lg">
                            <i class="fas fa-arrow-right"></i>
                            <span>Mulai Sekarang</span>
                        </a>
                        <a href="#features" class="btn-outline-lg">
                            <i class="fas fa-list-ul"></i>
                            <span>Lihat Fitur</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-bark-200">
                        <div>
                            <div class="text-2xl font-mono font-bold text-canopy-700">500+</div>
                            <div class="text-xs text-bark-500 mt-0.5">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-2xl font-mono font-bold text-canopy-700">10K+</div>
                            <div class="text-xs text-bark-500 mt-0.5">Lahan Terdaftar</div>
                        </div>
                        <div>
                            <div class="text-2xl font-mono font-bold text-canopy-700">99.9%</div>
                            <div class="text-xs text-bark-500 mt-0.5">Uptime</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white rounded-md border border-bark-100 p-6">
                        <div class="flex items-center justify-between mb-5 pb-4 border-b border-bark-100">
                            <div>
                                <p class="text-[11px] uppercase tracking-wide text-bark-500 font-semibold">Ikhtisar Kawasan</p>
                                <h3 class="text-lg font-display font-semibold text-ink">Dashboard Lahan</h3>
                            </div>
                            <div class="w-9 h-9 rounded-full border border-canopy-300 flex items-center justify-center">
                                <i class="fas fa-chart-pie text-canopy-700 text-sm"></i>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 rounded-md border border-bark-100 border-l-[3px] border-l-bark-500">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-industry text-bark-600 w-5"></i>
                                    <div>
                                        <div class="text-[11px] text-bark-500 uppercase tracking-wide">Hutan Produksi</div>
                                        <div class="text-base font-mono font-bold text-ink">125 Ha</div>
                                    </div>
                                </div>
                                <span class="status-badge status-Produksi">Produksi</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-md border border-bark-100 border-l-[3px] border-l-canopy-600">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-leaf text-canopy-700 w-5"></i>
                                    <div>
                                        <div class="text-[11px] text-bark-500 uppercase tracking-wide">Hutan Konservasi</div>
                                        <div class="text-base font-mono font-bold text-ink">85 Ha</div>
                                    </div>
                                </div>
                                <span class="status-badge status-Konservasi">Konservasi</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-md border border-bark-100 border-l-[3px] border-l-resin-500">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-seedling text-resin-600 w-5"></i>
                                    <div>
                                        <div class="text-[11px] text-bark-500 uppercase tracking-wide">Zona Reboisasi</div>
                                        <div class="text-base font-mono font-bold text-ink">60 Ha</div>
                                    </div>
                                </div>
                                <span class="status-badge status-Reboisasi">Reboisasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden sm:flex absolute -bottom-4 -left-4 items-center gap-2 bg-white border border-canopy-300 text-canopy-800 text-xs font-semibold px-3 py-2 rounded-md">
                        <i class="fas fa-circle-check text-canopy-600"></i> Mudah digunakan
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ LOGO / TRUST STRIP ============ -->
    <section class="py-8 bg-white border-y border-bark-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs text-bark-500 uppercase tracking-widest mb-4">Dipercaya oleh pengelola lahan di seluruh Indonesia</p>
            <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-3 text-bark-500 text-sm">
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-city"></i> Dinas Kehutanan</span>
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-seedling"></i> KPH Regional</span>
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-building"></i> Koperasi Tani Hutan</span>
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-tractor"></i> Perhutanan Sosial</span>
            </div>
        </div>
    </section>

    <!-- ============ FEATURES SECTION ============ -->
    <section id="features" class="py-20 bg-mist">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-[11px] uppercase tracking-[0.14em] text-bark-500 font-semibold mb-2">Fitur Unggulan</p>
                <h2 class="text-3xl lg:text-4xl font-display font-semibold text-ink mb-4">
                    Solusi Lengkap untuk Manajemen Hutan
                </h2>
                <p class="text-lg text-bark-600 max-w-2xl mx-auto">
                    Satu platform untuk memudahkan pencatatan dan pengelolaan lahan perhutanan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <h3 class="text-lg font-display font-semibold text-ink mb-2">Monitoring Real-Time</h3>
                    <p class="text-sm text-bark-600 leading-relaxed">Pantau kondisi lahan hutan Anda secara langsung dengan dashboard yang selalu diperbarui.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-database"></i></div>
                    <h3 class="text-lg font-display font-semibold text-ink mb-2">Manajemen Data</h3>
                    <p class="text-sm text-bark-600 leading-relaxed">Kelola data lahan, hasil hutan, dan inventaris dengan sistem yang terorganisir dan mudah diakses.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-halved"></i></div>
                    <h3 class="text-lg font-display font-semibold text-ink mb-2">Keamanan Terjamin</h3>
                    <p class="text-sm text-bark-600 leading-relaxed">Data Anda dilindungi dengan enkripsi tingkat enterprise dan backup otomatis setiap hari.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3 class="text-lg font-display font-semibold text-ink mb-2">Analisis &amp; Insight</h3>
                    <p class="text-sm text-bark-600 leading-relaxed">Dapatkan insight otomatis dan visualisasi grafik untuk mendukung pengambilan keputusan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-file-export"></i></div>
                    <h3 class="text-lg font-display font-semibold text-ink mb-2">Ekspor &amp; Laporan</h3>
                    <p class="text-sm text-bark-600 leading-relaxed">Unduh data ke CSV, cetak laporan, dan bagikan hasil analisis dengan mudah kapan saja.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-users"></i></div>
                    <h3 class="text-lg font-display font-semibold text-ink mb-2">Kolaborasi Tim</h3>
                    <p class="text-sm text-bark-600 leading-relaxed">Undang anggota tim untuk mengelola data lahan bersama dengan hak akses yang bisa diatur.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PRICING SECTION ============ -->
    <section id="pricing" class="py-20 bg-white border-y border-bark-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-[11px] uppercase tracking-[0.14em] text-bark-500 font-semibold mb-2">Paket Berlangganan</p>
                <h2 class="text-3xl lg:text-4xl font-display font-semibold text-ink mb-4">
                    Harga yang Simpel &amp; Transparan
                </h2>
                <p class="text-lg text-bark-600 max-w-2xl mx-auto">
                    Mulai gratis untuk lahan kecil, upgrade ke Premium kapan saja saat kebutuhan Anda bertambah. Tanpa kontrak, bisa batal kapan saja.
                </p>

                <!-- Toggle Bulanan / Tahunan -->
                <div class="inline-flex items-center bg-mist rounded-md p-1 mt-8 border border-bark-200">
                    <button id="billingMonthlyBtn" onclick="setBilling('monthly')" class="billing-toggle-btn billing-toggle-active">
                        Bulanan
                    </button>
                    <button id="billingYearlyBtn" onclick="setBilling('yearly')" class="billing-toggle-btn">
                        Tahunan <span class="ml-1 text-[10px] font-bold text-canopy-700 bg-canopy-50 px-2 py-0.5 rounded">Hemat 20%</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">

                <!-- Free Plan -->
                <div class="pricing-card">
                    <div class="mb-6">
                        <div class="w-12 h-12 rounded-md border border-bark-200 flex items-center justify-center mb-4">
                            <i class="fas fa-seedling text-bark-500"></i>
                        </div>
                        <h3 class="text-xl font-display font-semibold text-ink">Free</h3>
                        <p class="text-bark-500 mt-1 text-sm">Cocok untuk mencoba dan lahan skala kecil</p>
                    </div>

                    <div class="mb-6">
                        <span class="text-4xl font-mono font-bold text-ink">$0</span>
                        <span class="text-bark-500 text-sm">/bulan</span>
                    </div>

                    <a href="{{ route('register') }}" class="block text-center btn-outline-neutral-lg mb-8">
                        Mulai Gratis
                    </a>

                    <ul class="space-y-3 text-sm flex-1">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Maks. <b>10 lahan</b> terdaftar</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">1 pengguna (tanpa kolaborasi tim)</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Grafik analisis dasar (pie &amp; bar)</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Export CSV terbatas (1x per hari)</span>
                        </li>
                        <li class="flex items-start space-x-3 text-bark-300">
                            <i class="fas fa-xmark mt-0.5"></i>
                            <span>Tanpa insight otomatis &amp; rasio kebijakan</span>
                        </li>
                        <li class="flex items-start space-x-3 text-bark-300">
                            <i class="fas fa-xmark mt-0.5"></i>
                            <span>Tanpa cetak laporan &amp; unduh grafik</span>
                        </li>
                        <li class="flex items-start space-x-3 text-bark-300">
                            <i class="fas fa-xmark mt-0.5"></i>
                            <span>Dukungan komunitas via email (respons 3-5 hari)</span>
                        </li>
                    </ul>
                </div>

                <!-- Premium Plan -->
                <div class="pricing-card pricing-card-highlight">
                    <div class="pricing-ribbon">
                        <i class="fas fa-star mr-1"></i> Paling Populer
                    </div>

                    <div class="mb-6">
                        <div class="w-12 h-12 rounded-md bg-canopy-700 flex items-center justify-center mb-4">
                            <i class="fas fa-crown text-resin-400"></i>
                        </div>
                        <h3 class="text-xl font-display font-semibold text-ink">Premium</h3>
                        <p class="text-bark-500 mt-1 text-sm">Untuk pengelolaan lahan tanpa batas &amp; tim</p>
                    </div>

                    <div class="mb-2">
                        <span class="text-4xl font-mono font-bold text-ink" id="premiumPrice">$19</span>
                        <span class="text-bark-500 text-sm">/bulan</span>
                    </div>
                    <p class="text-xs text-canopy-700 font-semibold mb-6 h-4" id="premiumBillingNote">&nbsp;</p>

                    <a href="{{ route('register') }}" class="block text-center btn-primary-lg justify-center mb-8">
                        Coba Premium Sekarang
                    </a>

                    <ul class="space-y-3 text-sm flex-1">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink font-semibold">Lahan &amp; blok <b>tanpa batas</b></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Pengguna &amp; kolaborasi tim <b>tanpa batas</b></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Semua grafik: proporsi, tren, distribusi ukuran &amp; top lahan</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Insight otomatis &amp; rasio kawasan konservasi</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Export CSV &amp; cetak laporan <b>tanpa batas</b></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Unduh grafik (PNG) &amp; riwayat backup otomatis</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-canopy-600 mt-0.5"></i>
                            <span class="text-ink">Dukungan prioritas 24/7</span>
                        </li>
                    </ul>
                </div>
            </div>

            <p class="text-center text-sm text-bark-500 mt-10">
                <i class="fas fa-circle-question mr-1"></i> Butuh paket khusus untuk instansi/KPH? <a href="#faq" class="text-canopy-700 font-semibold hover:underline">Hubungi kami</a>.
            </p>
        </div>
    </section>

    <!-- ============ COMPARISON TABLE ============ -->
    <section class="py-16 bg-mist">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-display font-semibold text-ink text-center mb-8">Perbandingan Fitur Lengkap</h3>
            <div class="overflow-x-auto rounded-md border border-bark-100 bg-white">
                <table class="min-w-full divide-y divide-bark-100">
                    <thead class="bg-canopy-800">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold text-white uppercase tracking-wider">Fitur</th>
                            <th class="px-6 py-3.5 text-center text-[11px] font-bold text-canopy-200 uppercase tracking-wider">Free</th>
                            <th class="px-6 py-3.5 text-center text-[11px] font-bold text-resin-400 uppercase tracking-wider">Premium</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-bark-100 text-sm">
                        <tr>
                            <td class="px-6 py-3 text-ink">Jumlah lahan terdaftar</td>
                            <td class="px-6 py-3 text-center text-bark-500">10 lahan</td>
                            <td class="px-6 py-3 text-center font-semibold text-canopy-700">Tanpa batas</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-ink">Jumlah pengguna / tim</td>
                            <td class="px-6 py-3 text-center text-bark-500">1 pengguna</td>
                            <td class="px-6 py-3 text-center font-semibold text-canopy-700">Tanpa batas</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-ink">Grafik analisis</td>
                            <td class="px-6 py-3 text-center text-bark-500">Dasar (pie &amp; bar)</td>
                            <td class="px-6 py-3 text-center font-semibold text-canopy-700">Lengkap + insight otomatis</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-ink">Export CSV</td>
                            <td class="px-6 py-3 text-center text-bark-500">1x / hari</td>
                            <td class="px-6 py-3 text-center font-semibold text-canopy-700">Tanpa batas</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-ink">Cetak laporan &amp; unduh grafik</td>
                            <td class="px-6 py-3 text-center"><i class="fas fa-xmark text-bark-300"></i></td>
                            <td class="px-6 py-3 text-center"><i class="fas fa-check text-canopy-600"></i></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-ink">Dukungan pelanggan</td>
                            <td class="px-6 py-3 text-center text-bark-500">Email (3-5 hari)</td>
                            <td class="px-6 py-3 text-center font-semibold text-canopy-700">Prioritas 24/7</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ============ FAQ SECTION ============ -->
    <section id="faq" class="py-20 bg-white border-t border-bark-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <p class="text-[11px] uppercase tracking-[0.14em] text-bark-500 font-semibold mb-2">FAQ</p>
                <h2 class="text-3xl font-display font-semibold text-ink">Pertanyaan yang Sering Diajukan</h2>
            </div>

            <div class="space-y-3" id="faqList">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Apakah paket Free benar-benar gratis selamanya?</span>
                        <i class="fas fa-chevron-down text-canopy-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden">
                        Ya. Paket Free tidak memiliki masa percobaan, Anda bisa memakainya selamanya dengan batas 10 lahan dan 1 pengguna. Upgrade ke Premium hanya jika kebutuhan Anda bertambah.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana cara pembayaran paket Premium?</span>
                        <i class="fas fa-chevron-down text-canopy-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden">
                        Pembayaran paket Premium menggunakan mata uang USD melalui kartu kredit/debit, dapat dibayar bulanan atau tahunan (hemat 20%). Anda bisa berhenti berlangganan kapan saja.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Apa yang terjadi jika lahan saya melebihi 10 di paket Free?</span>
                        <i class="fas fa-chevron-down text-canopy-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden">
                        Anda akan diminta upgrade ke paket Premium untuk menambah lahan baru. Data yang sudah ada tetap aman dan tidak akan dihapus.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span>Apakah tersedia paket khusus untuk instansi pemerintah/KPH?</span>
                        <i class="fas fa-chevron-down text-canopy-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden">
                        Tersedia. Silakan hubungi tim kami untuk paket khusus dengan jumlah pengguna besar, integrasi sistem, dan SLA khusus instansi.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA SECTION ============ -->
    <section class="py-20 bg-canopy-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-display font-semibold text-white mb-4">Siap Mengelola Lahan Hutan dengan Lebih Baik?</h2>
            <p class="text-canopy-200 text-lg mb-8">Bergabunglah dengan ratusan pengelola lahan yang sudah beralih ke sistem digital. Gratis untuk memulai, tidak perlu kartu kredit.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}" class="bg-resin-500 hover:bg-resin-600 text-ink px-7 py-3.5 rounded-md font-bold transition flex items-center justify-center space-x-2">
                    <i class="fas fa-arrow-right"></i><span>Daftar Gratis Sekarang</span>
                </a>
                <a href="#pricing" class="border border-canopy-500 text-white hover:bg-canopy-800 px-7 py-3.5 rounded-md font-bold transition flex items-center justify-center space-x-2">
                    <i class="fas fa-crown"></i><span>Lihat Paket Premium</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER (SIMPEL) ============ -->
    <footer class="bg-ink text-bark-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center md:items-center justify-between gap-6 text-center md:text-left">

                <div class="flex items-center space-x-3 order-1">
                    <div class="w-9 h-9 rounded-full border border-bark-500 flex items-center justify-center shrink-0">
                        <i class="fas fa-tree text-resin-500 text-sm"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-base font-display font-semibold text-white leading-tight">Perhutani</span>
                        <span class="block text-xs text-bark-400">Monitoring Lahan &amp; Hasil Hutan</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm order-3 md:order-2">
                    <a href="#features" class="hover:text-resin-400 transition">Fitur</a>
                    <a href="#pricing" class="hover:text-resin-400 transition">Harga</a>
                    <a href="#faq" class="hover:text-resin-400 transition">FAQ</a>
                    <a href="#" class="hover:text-resin-400 transition">Kontak</a>
                    <a href="#" class="hover:text-resin-400 transition">Kebijakan Privasi</a>
                </div>

                <div class="flex space-x-3 order-2 md:order-3">
                    <a href="#" class="w-9 h-9 rounded-full border border-bark-600 hover:border-resin-500 flex items-center justify-center transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full border border-bark-600 hover:border-resin-500 flex items-center justify-center transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full border border-bark-600 hover:border-resin-500 flex items-center justify-center transition" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="border-t border-bark-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-xs text-bark-500">
                &copy; {{ date('Y') }} Perhutani. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <style type="text/tailwindcss">
        .btn-primary-lg { @apply bg-canopy-700 hover:bg-canopy-800 text-white px-7 py-3.5 rounded-md font-semibold transition flex items-center justify-center space-x-2; }
        .btn-outline-lg { @apply bg-white hover:bg-canopy-50 text-ink px-7 py-3.5 rounded-md font-semibold transition border border-bark-300 flex items-center justify-center space-x-2; }
        .btn-outline-neutral-lg { @apply bg-white hover:bg-mist text-ink px-6 py-3 rounded-md font-semibold transition border border-bark-300; }

        .feature-card { @apply bg-white rounded-md p-6 border border-bark-100 border-l-[3px] border-l-canopy-600 transition hover:border-l-resin-500; }
        .feature-icon { @apply w-11 h-11 rounded-md bg-canopy-50 border border-canopy-200 flex items-center justify-center mb-4 text-canopy-700; }

        .status-badge { @apply px-2.5 py-1 rounded text-[11px] font-bold border; }
        .status-Konservasi { @apply bg-canopy-50 text-canopy-800 border-canopy-300; }
        .status-Produksi { @apply bg-bark-100 text-bark-700 border-bark-300; }
        .status-Reboisasi { @apply bg-resin-100 text-resin-700 border-resin-300; }

        .billing-toggle-btn { @apply px-5 py-2 rounded text-sm font-semibold transition text-bark-600; }
        .billing-toggle-active { @apply bg-canopy-700 text-white; }

        .pricing-card { @apply relative bg-white rounded-md p-8 border border-bark-200 flex flex-col; }
        .pricing-card-highlight { @apply border-canopy-600 border-2; }
        .pricing-ribbon { @apply absolute -top-3.5 left-1/2 -translate-x-1/2 bg-canopy-700 text-white text-xs font-bold px-4 py-1.5 rounded whitespace-nowrap; }

        .faq-item { @apply bg-mist rounded-md border border-bark-100; }
        .faq-question { @apply w-full text-left px-6 py-4 flex items-center justify-between font-semibold text-ink; }
        .faq-answer { @apply px-6 pb-4 text-bark-600 text-sm; }
    </style>

    <script>
        // Toggle FAQ
        function toggleFaq(btn) {
            const answer = btn.nextElementSibling;
            const icon = btn.querySelector('i');
            document.querySelectorAll('.faq-answer').forEach(a => {
                if (a !== answer) { a.classList.add('hidden'); }
            });
            document.querySelectorAll('.faq-question i').forEach(i => {
                if (i !== icon) i.style.transform = 'rotate(0deg)';
            });
            const isOpen = !answer.classList.contains('hidden');
            answer.classList.toggle('hidden');
            icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        // Toggle billing bulanan / tahunan
        const monthlyPrice = 19;
        const yearlyPrice = (monthlyPrice * 12 * 0.8 / 12).toFixed(0); // efektif per bulan, hemat 20%

        function setBilling(mode) {
            const monthlyBtn = document.getElementById('billingMonthlyBtn');
            const yearlyBtn = document.getElementById('billingYearlyBtn');
            const price = document.getElementById('premiumPrice');
            const note = document.getElementById('premiumBillingNote');

            if (mode === 'monthly') {
                monthlyBtn.classList.add('billing-toggle-active');
                yearlyBtn.classList.remove('billing-toggle-active');
                price.textContent = '$' + monthlyPrice;
                note.innerHTML = '&nbsp;';
            } else {
                yearlyBtn.classList.add('billing-toggle-active');
                monthlyBtn.classList.remove('billing-toggle-active');
                price.textContent = '$' + yearlyPrice;
                note.textContent = 'Ditagih $' + (yearlyPrice * 12) + '/tahun';
            }
        }
    </script>
</body>
</html>
