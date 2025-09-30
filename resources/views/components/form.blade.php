@if (!empty($backPressed) ?? false)
    <div class="w-24 ml-auto">
        <x-buttons.primary title="{{__('Back')}}" :wireClick="$backPressed">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </x-buttons.primary>
    </div>
@endif
<form wire:submit.prevent="{{ $action ?? '' }}"
    class="{{ $noClass ?? false ? '' : 'p-4 my-5 bg-white rounded shadow' }}">
    {{ $slot }}
</form>
