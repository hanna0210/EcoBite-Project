<div x-show="currentStep == {{ $step ?? 1 }}">
    {{ $slot ?? '' }}

    <div class="flex justify-end gap-2 mt-4">
        @if ($showPrev ?? true)
            <x-buttons.plain :full="false" title="{{ $prevText ?? __('Previous') }}"
                wireClick="{{ $prevClick ?? 'prevStep' }}" bgColor="bg-gray-400">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                <span class="mx-1">{{ $prevText ?? __('Previous') }}</span>
            </x-buttons.plain>
        @endif

        @if ($showNext ?? true)
            <x-buttons.plain :full="false" title="{{ $nextText ?? __('Next') }}" wireClick="{{ $nextClick ?? '' }}"
                bgColor="bg-primary-600">
                <span class="mx-1">{{ $nextText ?? __('Next') }}</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </x-buttons.plain>
        @endif
    </div>
</div>
