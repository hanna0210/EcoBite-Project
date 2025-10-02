<div>
    <label class="block mt-4 text-sm">
        <span class="text-gray-700">{{ $title ?? '' }}</span>
        <div class="flex items-center">
            <input class='block w-full p-2 mt-1 text-sm border border-gray-300 rounded focus:border-primary-400 focus:outline-none focus:shadow-outline-primary' id="{{ rand(10,1000) }}" autocomplete="off" autocomplete="false" placeholder="{{ $placeholder ?? __('Search ').__(class_basename($model)) }}" type="{{ $type ?? 'text' }}" id='name' wire:model.debounce.700ms='name' {{ $disable ?'disabled':'' }} />
            @if ($showClear ?? false)
            <button type="button" class="h-full p-2 text-white bg-red-500 hover:shadow" wire:click="clearAutocompleteFieldsEvent">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            @endif
        </div>
        @error($name ?? '')
        <span class="mt-1 text-xs text-red-700">{{ $message }}</span>
        @enderror
    </label>

    {{-- result --}}
    <div class="p-2 text-sm text-gray-400" wire:loading wire:target="name">
        <svg class="w-4 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
    </div>

    @if ( !empty($dataList ?? []) )
    <div class="border rounded-sm shadow-sm bg-gray-50" wire:loading.remove wire:target="name">
        @foreach($dataList ?? [] as $key => $data)
        {{-- <div class="px-4 py-2 text-sm text-gray-500 border-b cursor-pointer" x-on:click="livewire.emit('{{ $emitFunction ?? '' }}',{{ $key }})" > --}}
        <div class="px-4 py-2 text-sm text-gray-500 border-b cursor-pointer" wire:click="optionSelected({{ $key }})">
            {{ $data['name'] }}
        </div>
        @endforeach

    </div>
    @endif

</div>
