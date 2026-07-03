<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Perhutanan - Sistem Monitoring Lahan & Hasil Hutan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">

    <!-- NAVBAR -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-lg border-b-2 border-emerald-500 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-br from-emerald-600 to-green-600 p-3 rounded-xl shadow-lg">
                        <i class="fas fa-tree text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-emerald-700 to-green-600 bg-clip-text text-transparent">SaaS Perhutanan</h1>
                        <p class="text-xs text-gray-500">Sistem Monitoring Lahan & Hasil Hutan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-emerald-700 font-medium transition duration-200 px-4 py-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-user-plus mr-2"></i>Daftar Gratis
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
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

    <!-- FEATURES SECTION -->
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

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-purple-200">
                    <div class="bg-purple-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Akses Multi-Device</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses sistem dari mana saja, kapan saja melalui desktop, tablet, atau smartphone Anda.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-red-200">
                    <div class="bg-red-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-file-export text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Laporan Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Generate laporan lengkap dan export data ke format Excel atau PDF dengan satu klik.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-8 hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-2 border-indigo-200">
                    <div class="bg-indigo-500 w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Multi-User</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kelola tim dengan role dan permission yang fleksibel untuk kolaborasi yang lebih baik.
                    </p>
                </div>
            </div>
        </div>
    </section>
