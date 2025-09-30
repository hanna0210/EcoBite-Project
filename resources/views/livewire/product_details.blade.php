@section('title', __('Product Details'))
<div>

    <x-baseview title="">

        @empty($selectedModel)
            <div class="p-4 border-2 rounded-xl text-primary-500 border-primary-500 opacity-20 centered">
                {{ __('No Product Found') }}
            </div>
        @else
            <div class="flex items-center">
                <div class="w-full space-y-1">
                    <p class='text-2xl font-semibold'> {{ $selectedModel->name }}</p>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-4 h-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
</svg>
                            <p>{{ __('Created On') }} : {{ $selectedModel->created_at->format('d M Y h:i a') }}</p>
                        </div>
                        <p>|</p>
                        <div class="flex items-center space-x-1 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-4 h-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
</svg>
                            <p>{{ __('Last Updated') }} : {{ $selectedModel->updated_at->format('d M Y h:i a') }}</p>
                        </div>
                    </div>
                </div>

            </div>
            {{-- analytics  --}}
            <div class="grid gap-6 mt-8 md:grid-cols-2 lg:grid-cols-4">

                {{-- Orders --}}
                <x-dashboard-card bg="bg-primary-500 text-white border-primary-500"
                    title="{{ __('Total Orders') }} [{{ __('Successful') }}]" value="{{ $ordersCount ?? 0 }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-16 text-white">
  <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
</svg>
                </x-dashboard-card>

                {{-- unit sold  --}}
                <x-dashboard-card bg="bg-primary-100" title="{{ __('Total Unit Sold') }} [{{ __('Successful') }}]"
                    value="{{ $totalUnitSold ?? 0 }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-16 ">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
</svg>
                </x-dashboard-card>

                {{-- totalPriceSold  --}}
                <x-dashboard-card bg="bg-primary-100" title="{{ __('Total Amount Sold') }} [{{ __('Successful') }}]"
                    value="{{ currencyformat($totalPriceSold ?? 0.0) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-16 "><path d="M 9 4 L 9 7.234375 L 5.515625 5.1425781 L 4.484375 6.8574219 L 6.3886719 8 L 3 8 L 3 27 L 9 27 L 9 25 L 5 25 L 5 10 L 13.027344 10 C 13.860344 9.38 14.884 9 16 9 C 16.352 9 16.682 9.0415625 17 9.1015625 L 17 8 L 13.611328 8 L 15.515625 6.8574219 L 14.484375 5.1425781 L 11 7.234375 L 11 4 L 9 4 z M 16 11 C 14.355 11 13 12.355 13 14 C 13 14.352 13.0745 14.684 13.1875 15 L 11 15 L 11 17 L 11 27 L 29 27 L 29 17 L 29 15 L 26.8125 15 C 26.9265 14.684 27 14.352 27 14 C 27 12.355 25.645 11 24 11 C 22.25 11 21.06225 12.3275 20.28125 13.4375 C 20.17625 13.5855 20.093 13.731953 20 13.876953 C 19.906 13.731953 19.82375 13.5865 19.71875 13.4375 C 18.93675 12.3275 17.75 11 16 11 z M 16 13 C 16.625 13 17.4375 13.6715 18.0625 14.5625 C 18.2145 14.7815 18.1915 14.793953 18.3125 15.001953 L 16 15.001953 C 15.434 15.001953 15 14.567953 15 14.001953 C 15 13.435953 15.434 13 16 13 z M 24 13 C 24.566 13 25 13.434 25 14 C 25 14.566 24.566 15 24 15 L 21.6875 15 C 21.8095 14.793 21.7855 14.7805 21.9375 14.5625 C 22.5625 13.6715 23.375 13 24 13 z M 13 17 L 19 17 L 19 25 L 13 25 L 13 17 z M 21 17 L 27 17 L 27 25 L 21 25 L 21 17 z"/></svg>
                </x-dashboard-card>



            </div>

            <div class="p-4 mt-10 bg-white rounded-md shadow ">

                {{-- user order list  --}}
                <p class="pb-4 text-xl font-bold">{{ __('Orders') }}</p>
                <livewire:tables.product-order-table productId="{{ $selectedModel->id }}" />

            </div>
        @endempty
    </x-baseview>

</div>
