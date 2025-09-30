<div class="text-sm">
    <div class="line-through text-gray-500">{{ $original_price }}</div>
    <div class="font-semibold text-green-600">{{ $rescue_price }}</div>
    @if($discount_percentage > 0)
        <div class="text-xs text-green-500">{{ $discount_percentage }}% off</div>
    @endif
</div>
