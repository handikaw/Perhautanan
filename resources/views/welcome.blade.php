<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhutani - Sistem Monitoring Lahan &amp; Hasil Hutan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">

    <!-- ============ NAVBAR ============ -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-lg border-b-2 border-emerald-500 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-emerald-600 to-green-600 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-tree text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-700 to-green-600 bg-clip-text text-transparent">Perhutani</h1>
                        <p class="text-xs text-gray-500">Sistem Monitoring Lahan &amp; Hasil Hutan</p>
                    </div>
                </div>

                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-emerald-700 font-medium transition">Fitur</a>
                    <a href="#pricing" class="text-gray-600 hover:text-emerald-700 font-medium transition">Harga</a>
                    <a href="#faq" class="text-gray-600 hover:text-emerald-700 font-medium transition">FAQ</a>
                </div>

                <div class="hidden sm:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-700 font-medium transition duration-200 px-4 py-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Gratis
                    </a>
                </div>

                <button id="mobileNavBtn" class="sm:hidden p-2 rounded-lg text-emerald-600" onclick="document.getElementById('mobileNav').classList.toggle('hidden')" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobileNav" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="px-4 py-4 space-y-3">
                <a href="#features" class="block text-gray-700 font-medium">Fitur</a>
                <a href="#pricing" class="block text-gray-700 font-medium">Harga</a>
                <a href="#faq" class="block text-gray-700 font-medium">FAQ</a>
                <a href="{{ route('login') }}" class="block text-gray-700 font-medium pt-2 border-t border-gray-100"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
                <a href="{{ route('register') }}" class="block bg-emerald-600 text-white text-center px-4 py-2.5 rounded-lg font-semibold"><i class="fas fa-user-plus mr-2"></i>Daftar Gratis</a>
            </div>
        </div>
    </nav>

    <!-- ============ HERO SECTION ============ -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500 rounded-full filter blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-block bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        <i class="fas fa-sparkles mr-2"></i>Platform SaaS Terpercaya
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Kelola Lahan Hutan Anda dengan
                        <span class="bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent">Lebih Cerdas</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistem monitoring dan manajemen lahan perhutanan yang modern, efisien, dan real-time. Pantau hasil hutan, kelola data, dan tingkatkan produktivitas dengan teknologi terdepan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition duration-200 shadow-2xl hover:shadow-3xl flex items-center justify-center space-x-2">
                            <i class="fas fa-rocket"></i>
                            <span>Mulai Sekarang</span>
                        </a>
                        <a href="#features" class="bg-white hover:bg-gray-50 text-gray-800 px-8 py-4 rounded-lg font-bold text-lg transition duration-200 shadow-lg hover:shadow-xl border-2 border-gray-200 flex items-center justify-center space-x-2">
                            <i class="fas fa-play-circle"></i>
                            <span>Lihat Fitur</span>
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                        <div>
                            <div class="text-3xl font-bold text-emerald-600">500+</div>
                            <div class="text-sm text-gray-600">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600">10K+</div>
                            <div class="text-sm text-gray-600">Lahan Terdaftar</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-teal-600">99.9%</div>
                            <div class="text-sm text-gray-600">Uptime</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-8">
                            <div class="text-center mb-6">
                                <div class="inline-block bg-emerald-600 p-6 rounded-full shadow-xl mb-4">
                                    <i class="fas fa-chart-line text-white text-6xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">Dashboard Interaktif</h3>
                                <p class="text-gray-600 mt-2">Monitor lahan hutan secara real-time</p>
                            </div>
                            <div class="bg-white rounded-lg shadow-lg p-4 space-y-3">
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-500 p-2 rounded-lg">
                                            <i class="fas fa-industry text-white"></i>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Hutan Produksi</div>
                                            <div class="text-lg font-bold text-gray-800">125 Ha</div>
                                        </div>
                                    </div>
                                    <i class="fas fa-arrow-up text-green-500"></i>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-green-500 p-2 rounded-lg">
                                            <i class="fas fa-leaf text-white"></i>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Hutan Konservasi</div>
                                            <div class="text-lg font-bold text-gray-800">85 Ha</div>
                                        </div>
                                    </div>
                                    <i class="fas fa-arrow-up text-green-500"></i>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-yellow-500 p-2 rounded-lg">
                                            <i class="fas fa-tree text-white"></i>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">Zona Reboisasi</div>
                                            <div class="text-lg font-bold text-gray-800">60 Ha</div>
                                        </div>
                                    </div>
                                    <i class="fas fa-arrow-up text-green-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-6 -right-6 bg-emerald-500 text-white px-4 py-2 rounded-full shadow-xl font-bold animate-bounce">
                        <i class="fas fa-check-circle mr-2"></i>Mudah Digunakan
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-green-500 text-white px-4 py-2 rounded-full shadow-xl font-bold animate-pulse">
                        <i class="fas fa-shield-alt mr-2"></i>100% Aman
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ LOGO / TRUST STRIP ============ -->
    <section class="py-8 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-400 uppercase tracking-widest mb-4">Dipercaya oleh pengelola lahan di seluruh Indonesia</p>
            <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-3 text-gray-400">
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-city"></i> Dinas Kehutanan</span>
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-seedling"></i> KPH Regional</span>
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-building"></i> Koperasi Tani Hutan</span>
                <span class="font-semibold flex items-center gap-2"><i class="fas fa-tractor"></i> Perhutanan Sosial</span>
            </div>
        </div>
    </section>

    <!-- ============ FEATURES SECTION ============ -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-star mr-2"></i>Fitur Unggulan
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Solusi Lengkap untuk <span class="text-emerald-600">Manajemen Hutan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Platform all-in-one yang dirancang khusus untuk memudahkan pengelolaan lahan perhutanan Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-blue-200">
                    <div class="bg-blue-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Monitoring Real-Time</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau kondisi lahan hutan Anda secara langsung dengan dashboard interaktif dan data yang selalu update.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-green-200">
                    <div class="bg-green-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-database text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Manajemen Data</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kelola data lahan, hasil hutan, dan inventaris dengan sistem yang terorganisir dan mudah diakses.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-yellow-200">
                    <div class="bg-yellow-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Data Anda dilindungi dengan enkripsi tingkat enterprise dan backup otomatis setiap hari.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-teal-200">
                    <div class="bg-teal-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-chart-pie text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Analisis &amp; Insight</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan insight otomatis dan visualisasi grafik untuk mendukung pengambilan keputusan yang lebih baik.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-amber-200">
                    <div class="bg-amber-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-file-export text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Ekspor &amp; Laporan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Unduh data ke CSV, cetak laporan, dan bagikan hasil analisis dengan mudah kapan saja.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-rose-200">
                    <div class="bg-rose-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Kolaborasi Tim</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Undang anggota tim untuk mengelola data lahan bersama dengan hak akses yang bisa diatur.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PRICING SECTION ============ -->
    <section id="pricing" class="py-20 bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-tags mr-2"></i>Paket Berlangganan
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Harga yang <span class="text-emerald-600">Simpel &amp; Transparan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Mulai gratis untuk lahan kecil, upgrade ke Pro kapan saja saat kebutuhan Anda bertambah. Tanpa kontrak, bisa batal kapan saja.
                </p>

                <!-- Toggle Bulanan / Tahunan -->
                <div class="inline-flex items-center bg-white rounded-full p-1.5 shadow-md mt-8 border border-gray-100">
                    <button id="billingMonthlyBtn" onclick="setBilling('monthly')" class="billing-toggle-btn px-5 py-2 rounded-full text-sm font-semibold transition bg-emerald-600 text-white">
                        Bulanan
                    </button>
                    <button id="billingYearlyBtn" onclick="setBilling('yearly')" class="billing-toggle-btn px-5 py-2 rounded-full text-sm font-semibold transition text-gray-600">
                        Tahunan <span class="ml-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Hemat 20%</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

                <!-- Free Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-200 flex flex-col">
                    <div class="mb-6">
                        <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center mb-4">
                            <i class="fas fa-seedling text-gray-500 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Free</h3>
                        <p class="text-gray-500 mt-1">Cocok untuk mencoba dan lahan skala kecil</p>
                    </div>

                    <div class="mb-6">
                        <span class="text-5xl font-bold text-gray-900">$0</span>
                        <span class="text-gray-500">/bulan</span>
                    </div>

                    <a href="{{ route('register') }}" class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-bold transition mb-8">
                        Mulai Gratis
                    </a>

                    <ul class="space-y-3 text-sm flex-1">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Maks. <b>10 lahan</b> terdaftar</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">1 pengguna (tanpa kolaborasi tim)</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Grafik analisis dasar (pie &amp; bar)</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Export CSV terbatas (1x per hari)</span>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-400">
                            <i class="fas fa-times-circle mt-0.5"></i>
                            <span>Tanpa insight otomatis &amp; rasio kebijakan</span>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-400">
                            <i class="fas fa-times-circle mt-0.5"></i>
                            <span>Tanpa cetak laporan &amp; unduh grafik</span>
                        </li>
                        <li class="flex items-start space-x-3 text-gray-400">
                            <i class="fas fa-times-circle mt-0.5"></i>
                            <span>Dukungan komunitas via email (respons 3-5 hari)</span>
                        </li>
                    </ul>
                </div>

                <!-- Pro Plan -->
                <div class="relative bg-white rounded-2xl shadow-2xl p-8 border-2 border-emerald-500 flex flex-col scale-105">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-emerald-600 to-green-600 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg whitespace-nowrap">
                        <i class="fas fa-star mr-1"></i> Paling Populer
                    </div>

                    <div class="mb-6">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-600 to-green-600 flex items-center justify-center mb-4 shadow-lg">
                            <i class="fas fa-crown text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Pro</h3>
                        <p class="text-gray-500 mt-1">Untuk pengelolaan lahan tanpa batas &amp; tim</p>
                    </div>

                    <div class="mb-2">
                        <span class="text-5xl font-bold text-gray-900" id="proPrice">$19</span>
                        <span class="text-gray-500">/bulan</span>
                    </div>
                    <p class="text-xs text-emerald-600 font-semibold mb-6 h-4" id="proBillingNote">&nbsp;</p>

                    <a href="{{ route('subscription.checkout', ['plan' => 'pro', 'cycle' => 'monthly']) }}" class="block text-center bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-6 py-3 rounded-lg font-bold shadow-lg transition mb-8">
                        Coba Pro Sekarang
                    </a>

                    <ul class="space-y-3 text-sm flex-1">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700 font-semibold">Lahan &amp; blok <b>tanpa batas</b></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Pengguna &amp; kolaborasi tim <b>tanpa batas</b></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Semua grafik: proporsi, tren, distribusi ukuran &amp; top lahan</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Insight otomatis &amp; rasio kawasan konservasi</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Export CSV &amp; cetak laporan <b>tanpa batas</b></span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Unduh grafik (PNG) &amp; riwayat backup otomatis</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                            <span class="text-gray-700">Dukungan prioritas 24/7</span>
                        </li>
                    </ul>
                </div>
            </div>

            <p class="text-center text-sm text-gray-500 mt-10">
                <i class="fas fa-circle-question mr-1"></i> Butuh paket khusus untuk instansi/KPH? <a href="#faq" class="text-emerald-600 font-semibold hover:underline">Hubungi kami</a>.
            </p>
        </div>
    </section>

    <!-- ============ COMPARISON TABLE ============ -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">Perbandingan Fitur Lengkap</h3>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Fitur</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Free</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-emerald-700 uppercase tracking-wider">Pro</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-sm">
                        <tr>
                            <td class="px-6 py-3 text-gray-700">Jumlah lahan terdaftar</td>
                            <td class="px-6 py-3 text-center text-gray-500">10 lahan</td>
                            <td class="px-6 py-3 text-center font-semibold text-emerald-700">Tanpa batas</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-gray-700">Jumlah pengguna / tim</td>
                            <td class="px-6 py-3 text-center text-gray-500">1 pengguna</td>
                            <td class="px-6 py-3 text-center font-semibold text-emerald-700">Tanpa batas</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-gray-700">Grafik analisis</td>
                            <td class="px-6 py-3 text-center text-gray-500">Dasar (pie &amp; bar)</td>
                            <td class="px-6 py-3 text-center font-semibold text-emerald-700">Lengkap + insight otomatis</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-gray-700">Export CSV</td>
                            <td class="px-6 py-3 text-center text-gray-500">1x / hari</td>
                            <td class="px-6 py-3 text-center font-semibold text-emerald-700">Tanpa batas</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-gray-700">Cetak laporan &amp; unduh grafik</td>
                            <td class="px-6 py-3 text-center"><i class="fas fa-times text-gray-300"></i></td>
                            <td class="px-6 py-3 text-center"><i class="fas fa-check text-emerald-600"></i></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 text-gray-700">Dukungan pelanggan</td>
                            <td class="px-6 py-3 text-center text-gray-500">Email (3-5 hari)</td>
                            <td class="px-6 py-3 text-center font-semibold text-emerald-700">Prioritas 24/7</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ============ FAQ SECTION ============ -->
    <section id="faq" class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-circle-question mr-2"></i>FAQ
                </div>
                <h2 class="text-4xl font-bold text-gray-900">Pertanyaan yang Sering Diajukan</h2>
            </div>

            <div class="space-y-4" id="faqList">
                <div class="faq-item bg-white rounded-xl shadow-sm border border-gray-100">
                    <button class="faq-question w-full text-left px-6 py-4 flex items-center justify-between font-semibold text-gray-800" onclick="toggleFaq(this)">
                        <span>Apakah paket Free benar-benar gratis selamanya?</span>
                        <i class="fas fa-chevron-down text-emerald-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-600 text-sm">
                        Ya. Paket Free tidak memiliki masa percobaan, Anda bisa memakainya selamanya dengan batas 10 lahan dan 1 pengguna. Upgrade ke Pro hanya jika kebutuhan Anda bertambah.
                    </div>
                </div>
                <div class="faq-item bg-white rounded-xl shadow-sm border border-gray-100">
                    <button class="faq-question w-full text-left px-6 py-4 flex items-center justify-between font-semibold text-gray-800" onclick="toggleFaq(this)">
                        <span>Bagaimana cara pembayaran paket Pro?</span>
                        <i class="fas fa-chevron-down text-emerald-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-600 text-sm">
                        Pembayaran paket Pro menggunakan mata uang USD melalui kartu kredit/debit, dapat dibayar bulanan atau tahunan (hemat 20%). Anda bisa berhenti berlangganan kapan saja.
                    </div>
                </div>
                <div class="faq-item bg-white rounded-xl shadow-sm border border-gray-100">
                    <button class="faq-question w-full text-left px-6 py-4 flex items-center justify-between font-semibold text-gray-800" onclick="toggleFaq(this)">
                        <span>Apa yang terjadi jika lahan saya melebihi 10 di paket Free?</span>
                        <i class="fas fa-chevron-down text-emerald-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-600 text-sm">
                        Anda akan diminta upgrade ke paket Pro untuk menambah lahan baru. Data yang sudah ada tetap aman dan tidak akan dihapus.
                    </div>
                </div>
                <div class="faq-item bg-white rounded-xl shadow-sm border border-gray-100">
                    <button class="faq-question w-full text-left px-6 py-4 flex items-center justify-between font-semibold text-gray-800" onclick="toggleFaq(this)">
                        <span>Apakah tersedia paket khusus untuk instansi pemerintah/KPH?</span>
                        <i class="fas fa-chevron-down text-emerald-600 transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-6 pb-4 text-gray-600 text-sm">
                        Tersedia. Silakan hubungi tim kami untuk paket khusus dengan jumlah pengguna besar, integrasi sistem, dan SLA khusus instansi.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA SECTION ============ -->
    <section class="py-20 bg-gradient-to-r from-emerald-600 to-green-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-10 -left-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-white rounded-full filter blur-3xl"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl font-bold text-white mb-4">Siap Mengelola Lahan Hutan dengan Lebih Baik?</h2>
            <p class="text-emerald-50 text-lg mb-8">Bergabunglah dengan ratusan pengelola lahan yang sudah beralih ke sistem digital. Gratis untuk memulai, tidak perlu kartu kredit.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-emerald-700 hover:bg-emerald-50 px-8 py-4 rounded-lg font-bold text-lg transition shadow-xl flex items-center justify-center space-x-2">
                    <i class="fas fa-rocket"></i><span>Daftar Gratis Sekarang</span>
                </a>
                <a href="#pricing" class="bg-emerald-700/40 hover:bg-emerald-700/60 text-white border-2 border-white/40 px-8 py-4 rounded-lg font-bold text-lg transition flex items-center justify-center space-x-2">
                    <i class="fas fa-crown"></i><span>Lihat Paket Pro</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER (SIMPEL) ============ -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-emerald-600 to-green-600 p-2 rounded-lg">
                        <i class="fas fa-tree text-white text-lg"></i>
                    </div>
                    <span class="text-lg font-bold text-white">Perhutani</span>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm">
                    <a href="#features" class="hover:text-emerald-400 transition">Fitur</a>
                    <a href="#pricing" class="hover:text-emerald-400 transition">Harga</a>
                    <a href="#faq" class="hover:text-emerald-400 transition">FAQ</a>
                    <a href="#" class="hover:text-emerald-400 transition">Kontak</a>
                    <a href="#" class="hover:text-emerald-400 transition">Kebijakan Privasi</a>
                </div>

                <div class="flex space-x-3">
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-emerald-600 flex items-center justify-center transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-emerald-600 flex items-center justify-center transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-emerald-600 flex items-center justify-center transition"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-6 pt-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Perhutani. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

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
            const price = document.getElementById('proPrice');
            const note = document.getElementById('proBillingNote');

            if (mode === 'monthly') {
                monthlyBtn.className = 'billing-toggle-btn px-5 py-2 rounded-full text-sm font-semibold transition bg-emerald-600 text-white';
                yearlyBtn.className = 'billing-toggle-btn px-5 py-2 rounded-full text-sm font-semibold transition text-gray-600';
                price.textContent = '$' + monthlyPrice;
                note.innerHTML = '&nbsp;';
            } else {
                yearlyBtn.className = 'billing-toggle-btn px-5 py-2 rounded-full text-sm font-semibold transition bg-emerald-600 text-white';
                monthlyBtn.className = 'billing-toggle-btn px-5 py-2 rounded-full text-sm font-semibold transition text-gray-600';
                price.textContent = '$' + yearlyPrice;
                note.textContent = 'Ditagih $' + (yearlyPrice * 12) + '/tahun';
            }
        }
    </script>
</body>
</html>