<div class="text-sm">
    @if($is_available)
        <div class="text-green-600 font-medium">Available</div>
        @if($time_remaining && $time_remaining !== 'expired')
            <div class="text-xs text-orange-500">{{ $time_remaining }}</div>
        @endif
    @else
        <div class="text-red-600 font-medium">
            @if($time_remaining === 'expired')
                Expired
            @else
                Not Available
            @endif
        </div>
    @endif
    
    @if($available_from)
        <div class="text-xs text-gray-500 mt-1">
            From: {{ $available_from->format('M d, H:i') }}
        </div>
    @endif
    @if($available_until)
        <div class="text-xs text-gray-500">
            Until: {{ $available_until->format('M d, H:i') }}
        </div>
    @endif
</div>
