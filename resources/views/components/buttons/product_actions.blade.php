<div x-data="{ showMore: false }">
    <div class="flex flex-wrap items-center space-x-2 gap-y-2">
        <x-buttons.show :model="$model" />
        {{-- timing --}}
        <button
            class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray"
            wire:click="$emit('changeProductTiming', {{ $model->id }} ) " title="{{ __('Edit Open/close time') }}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            {{ $slot ?? '' }}
        </button>

        <x-buttons.edit :model="$model" />

        {{-- <button type="button"
            class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-600 focus:outline-none focus:shadow-outline-gray"
            x-on:click="showMore = !showMore" title="{{ __('More') }}">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
            </svg>
        </button> --}}
        {{-- </div> --}}
        {{-- <div class="mt-2 flex flex-wrap items-center space-x-2 gap-y-2" x-show="showMore"> --}}

        @if ($model->is_active)
            <x-buttons.deactivate :model="$model" />
        @else
            <x-buttons.activate :model="$model" />
        @endif
        <x-buttons.delete :model="$model" />
        @if ($model->available_qty != null && $model->available_qty > 0)
            <x-buttons.plain bgColor="bg-red-500" wireClick="$emit('setOutOfStock', {{ $model->id }} )"
                title="{{ __('Set product to out of stock') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 18.726563 26.011719 21.207031 24.375 23.125 L 9.03125 7.46875 C 10.925781 5.917969 13.351563 5 16 5 Z M 7.625 8.875 L 22.96875 24.53125 C 21.074219 26.082031 18.648438 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 13.273438 5.988281 10.792969 7.625 8.875 Z"/></svg>
            </x-buttons.plain>
        @endif

        {{-- report --}}
        <a href="{{ route('product.details', ['id' => $model->id]) }}" target="_blank">
            <x-buttons.plain bgColor="bg-primary-500" title="{{ __('View product report') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 14.875 5.0625 C 14.917969 5.058594 14.957031 5.066406 15 5.0625 L 15 16.40625 L 15.28125 16.71875 L 23.0625 24.46875 C 21.15625 26.0625 18.6875 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 10.292969 9.320313 5.625 14.875 5.0625 Z M 17 5.0625 C 22.285156 5.539063 26.460938 9.714844 26.9375 15 L 17 15 Z M 18.4375 17 L 26.9375 17 C 26.730469 19.292969 25.863281 21.394531 24.46875 23.0625 Z"/></svg>
            </x-buttons.plain>
        </a>


    </div>
</div>
