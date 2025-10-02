@if (!empty($backPressed) ?? false)
    <div class="w-24 ml-auto">
        <x-buttons.primary title="{{__('Back')}}" :wireClick="$backPressed">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </x-buttons.primary>
    </div>
@endif
<form wire:submit.prevent="{{ $action ?? '' }}"
    class="{{ $noClass ?? false ? '' : 'p-4 my-5 bg-white rounded shadow' }}">
    {{ $slot }}
</form>
