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
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            <p class="text-sm">{{ __('Sync Boudaries') }}</p>
        </x-buttons.plain>
        {{-- @endempty --}}
    @endproduction
</div>
