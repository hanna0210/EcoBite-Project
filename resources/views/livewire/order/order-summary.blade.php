<div class="bg-white shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full">
        <tbody>
            @foreach ($breakdown as $index => $item)
                @php
                    $isTotal = isset($item['is_total']) && $item['is_total'];
                    $isDiscount = isset($item['is_discount']) && $item['is_discount'];
                    $isFee = isset($item['is_fee']) && $item['is_fee'];
                @endphp
                <tr class="flex border-b border-gray-100 last:border-b-2 last:border-gray-300">
                    <td
                        class="w-6/12 md:w-8/12 lg:w-9/12 text-sm text-right pr-4 py-3 px-3 text-gray-700
                        {{ $isTotal ? 'font-semibold text-gray-800' : '' }}">
                        {{ $item['key'] }}
                    </td>
                    <td
                        class="w-6/12 md:w-4/12 lg:w-3/12 text-right py-3 px-3 font-medium
                        {{ $isTotal ? 'font-bold text-gray-900' : '' }}
                        {{ $isDiscount ? 'text-grey-600' : '' }}
                        {{ $isFee ? 'text-primary-500' : '' }}">
                        {{ $item['value'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
