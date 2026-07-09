{{-- resources/views/pricing.blade.php --}}
<div class="max-w-4xl mx-auto rounded-xl overflow-hidden border border-gray-200 my-10">
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
</div>
