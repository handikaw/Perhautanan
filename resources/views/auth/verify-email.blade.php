<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email &middot; Perhutani</title>

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
<body class="bg-mist font-body text-ink min-h-screen flex items-center justify-center px-4 py-10" style="background-image:radial-gradient(rgba(38,33,26,0.05) 1px, transparent 1px); background-size: 20px 20px;">

    <div class="max-w-md w-full">

        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-full border-2 border-resin-500/70 items-center justify-center mb-4 bg-canopy-900">
                <i class="fas fa-tree text-resin-500 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-display font-semibold text-ink mb-1">Perhutani</h1>
            <p class="text-bark-600 text-sm">Monitoring Lahan &amp; Hasil Hutan</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-md border border-bark-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-canopy-800 px-8 py-5">
                <h2 class="text-lg font-display font-semibold text-white flex items-center space-x-2">
                    <i class="fas fa-envelope-circle-check"></i>
                    <span>Verifikasi Email</span>
                </h2>
                <p class="text-canopy-200 text-sm mt-1">Satu langkah lagi sebelum akun Anda aktif</p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-8">

                <div class="text-sm text-bark-600 leading-relaxed mb-5">
                    {{ __('Terima kasih sudah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan. Jika Anda belum menerima email tersebut, kami akan dengan senang hati mengirimkan yang baru.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-5 bg-canopy-50 border-l-2 border-canopy-600 text-canopy-800 p-3 rounded-md">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-circle-check"></i>
                            <span class="text-sm">{{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.') }}</span>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between pt-1">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Ulang Email Verifikasi</span>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-bark-600 hover:text-clay-600 font-medium underline transition">
                            {{ __('Keluar') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6 text-xs text-bark-500">
            <p><i class="fas fa-shield-halved text-canopy-600 mr-1"></i>Verifikasi email melindungi keamanan akun Anda</p>
        </div>

    </div>

    <style type="text/tailwindcss">
        .btn-primary { @apply bg-canopy-700 hover:bg-canopy-800 text-white font-semibold py-2.5 px-5 rounded-md transition duration-200 flex items-center space-x-2 text-sm; }
    </style>

</body>
</html>