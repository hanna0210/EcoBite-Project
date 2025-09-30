<div>
    <label class="block {{ $title != null && !empty($title) ? 'mt-4' : '' }} text-sm">
        @if ($title != null && !empty($title))
            <span class="text-gray-700">{{ $title ?? '' }}</span>
        @endif
        <input
            class='block w-full p-2 mt-1 text-sm border border-gray-300 rounded focus:border-primary-400 focus:outline-none focus:shadow-outline-primary'
            autocomplete="off" placeholder="{{ $placeholder ?? '' }}" type="{{ $type ?? 'text' }}"
            id='{{ $elementId ?? ($name ?? '') }}' wire:model.debounce.700ms='{{ $name ?? '' }}' />
        @error($name ?? '')
            <span class="mt-1 text-xs text-red-700">{{ $message }}</span>
        @enderror
    </label>

    {{-- result --}}
    <div class="p-2 text-sm text-gray-400" wire:loading wire:target="{{ $name ?? '' }}">
        <svg class="w-4 h-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
    </div>
    <div class="border rounded-sm shadow-sm bg-gray-50" wire:loading.remove wire:target="{{ $name ?? '' }}">
        @foreach ($addresses ?? [] as $key => $address)
            <div class="px-4 py-2 text-sm text-gray-500 border-b cursor-pointer"
                wire:click="addressSelected({{ $key }})">
                <p>
                    {{ $address['name'] }}
                    -
                    {{ $address['address'] ?? '' }}
                </p>
            </div>
        @endforeach

    </div>

</div>
