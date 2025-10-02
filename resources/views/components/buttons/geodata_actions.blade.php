<div class="flex items-center gap-x-2">
    @if ($model->is_active)
        <x-buttons.deactivate :model="$model" />
    @else
        <x-buttons.activate :model="$model" />
    @endif
    <x-buttons.edit :model="$model" target="$target ?? ''" />
    <x-buttons.delete :model="$model" target="$target ?? ''" />
    {{-- add sync boudaries button --}}
    @production
        {{-- @empty($model->boundaries) --}}
        <x-buttons.plain wireClick="syncModelBoundaries({{ $model->id ?? ($id ?? '') }})" title="{{ __('Sync Boudaries') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <p class="text-sm">{{ __('Sync Boudaries') }}</p>
        </x-buttons.plain>
        {{-- @endempty --}}
    @endproduction
</div>
