<div class="text-sm">
    <div class="{{ $is_sold_out ? 'text-red-600' : 'text-gray-900' }}">
        {{ $available }}/{{ $total }}
    </div>
    @if($is_sold_out)
        <div class="text-xs text-red-500">Sold Out</div>
    @else
        <div class="text-xs text-gray-500">Available</div>
    @endif
</div>
