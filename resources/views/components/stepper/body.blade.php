<div x-show="currentStep == {{ $step ?? 1 }}">
    {{ $slot ?? '' }}

    <div class="flex justify-end gap-2 mt-4">
        @if ($showPrev ?? true)
            <x-buttons.plain :full="false" title="{{ $prevText ?? __('Previous') }}"
                wireClick="{{ $prevClick ?? 'prevStep' }}" bgColor="bg-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="mx-1">{{ $prevText ?? __('Previous') }}</span>
            </x-buttons.plain>
        @endif

        @if ($showNext ?? true)
            <x-buttons.plain :full="false" title="{{ $nextText ?? __('Next') }}" wireClick="{{ $nextClick ?? '' }}"
                bgColor="bg-primary-600">
                <span class="mx-1">{{ $nextText ?? __('Next') }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </x-buttons.plain>
        @endif
    </div>
</div>
