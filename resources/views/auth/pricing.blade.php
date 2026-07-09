{{-- resources/views/pricing.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbandingan Paket - Perhutanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    @if (session('success'))
        <div class="max-w-4xl mx-auto mt-6 bg-green-100 text-green-800 text-sm px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-4xl mx-auto mt-6 bg-red-100 text-red-800 text-sm px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto rounded-xl overflow-hidden border border-gray-200 my-10 bg-white shadow-sm">
    <table class="w-full border-collapse table-fixed">
        <colgroup>
            <col class="w-[34%]">
            <col class="w-[33%]">
            <col class="w-[33%]">
        </colgroup>
        <thead>
            <tr class="bg-[#1f2e1a]">
                <th class="text-left px-5 py-4 text-white text-xs font-semibold tracking-wider uppercase">Fitur</th>
                <th class="text-center px-5 py-4 text-white text-xs font-semibold tracking-wider uppercase">Free</th>
                <th class="text-center px-5 py-4 text-[#e0a94a] text-xs font-semibold tracking-wider uppercase">Premium</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($features as $feature)
                <tr class="border-b border-gray-100 last:border-b-0">
                    <td class="px-5 py-4 text-sm text-gray-800">
                        {{ $feature->feature_name }}
                    </td>

                    <td class="px-5 py-4 text-sm text-center text-[#b06a3c]">
                        @if ($feature->value_type === 'boolean')
                            @if ($feature->free_bool)
                                <span class="text-gray-700">&#10003;</span>
                            @else
                                <span class="text-gray-300">&times;</span>
                            @endif
                        @else
                            {{ $feature->free_text }}
                        @endif
                    </td>

                    <td class="px-5 py-4 text-sm text-center font-medium text-gray-900">
                        @if ($feature->value_type === 'boolean')
                            @if ($feature->premium_bool)
                                <span class="text-gray-900">&#10003;</span>
                            @else
                                <span class="text-gray-300">&times;</span>
                            @endif
                        @else
                            {{ $feature->premium_text }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @auth
        @if (!auth()->user()->is_premium)
            <div class="p-5 text-center border-t border-gray-100">
                <form action="{{ route('premium.upgrade') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-[#e0a94a] text-[#1f2e1a] font-semibold px-6 py-2 rounded-lg hover:opacity-90">
                        Upgrade ke Premium
                    </button>
                </form>
            </div>
        @else
            <div class="p-5 text-center border-t border-gray-100 text-sm text-gray-500">
                Akun kamu sudah Premium ✓
            </div>
        @endif
    @endauth
    </div>

    <div class="max-w-4xl mx-auto text-center pb-10">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
            &larr; Kembali ke Dashboard
        </a>
    </div>

</body>
</html>