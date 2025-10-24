<label class="block mt-4 text-sm">
    <span class="text-gray-700">{{ $title ?? '' }}</span>
    <textarea 
        id='{{ $id ?? $name ?? '' }}'
        name='{{ $name ?? '' }}'
        placeholder="{{ $placeholder ?? '' }}"
        autocomplete="{{ $autocomplete ?? 'off' }}"
        @if ( $defer ?? true )
            wire:model.defer='{{ $name ?? '' }}'
        @else
            wire:model='{{ $name ?? '' }}'
        @endif
        @if ($disable ?? false) disabled @endif
      class="w-full {{ $h ?? 'h-40' }} p-2 mt-1 border rounded"></textarea>
      
    @error($name ?? '')
        <span class="mt-1 text-xs text-red-700">{{ $message }}</span>
    @enderror
  </label>
