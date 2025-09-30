@section('title', __('Summary Report'))
<div>

    <x-baseview title="{{ __('Summary Report') }}">


        <div class="p-4 border rounded-md shadow-sm">
            <p class="text-sm font-light">{{ __('Show Data by Date Range') }}</p>
            {{-- filter form  --}}
            <x-form action="loadData">
                <div class="grid grid-cols-2 gap-4 mt-1 mb-6 md:grid-cols-3">
                    <x-input type="date" name="startDate" />
                    <x-input type="date" name="endDate" />
                    <x-buttons.primary title="{{ __('Show') }}" noMargin="true" />
                </div>
            </x-form>
            {{-- money  --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4">
                {{-- admin  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6 text-gray-500"><path d="M 16 5 C 12.144531 5 9 8.144531 9 12 C 9 14.410156 10.230469 16.550781 12.09375 17.8125 C 8.527344 19.34375 6 22.882813 6 27 L 8 27 C 8 22.570313 11.570313 19 16 19 C 20.429688 19 24 22.570313 24 27 L 26 27 C 26 22.882813 23.472656 19.34375 19.90625 17.8125 C 21.769531 16.550781 23 14.410156 23 12 C 23 8.144531 19.855469 5 16 5 Z M 16 7 C 18.773438 7 21 9.226563 21 12 C 21 14.773438 18.773438 17 16 17 C 13.226563 17 11 14.773438 11 12 C 11 9.226563 13.226563 7 16 7 Z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Admin earned') }}</p>
                        <p class="font-medium text-primary-600">{{ currencyFormat($adminEarned ?? 0.0) }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6 text-gray-500"><path d="M 4 4 L 4 7.65625 L 1 11.65625 L 1 12 C 1 13.645 2.355 15 4 15 L 4 28 L 28 28 L 28 15 C 29.645 15 31 13.645 31 12 L 31 11.65625 L 28 7.65625 L 28 4 L 4 4 z M 6 6 L 26 6 L 26 7 L 6 7 L 6 6 z M 5.5 9 L 26.5 9 L 28.90625 12.21875 C 28.79725 12.65175 28.469 13 28 13 C 27.445 13 27 12.555 27 12 L 25 12 C 25 12.555 24.555 13 24 13 C 23.445 13 23 12.555 23 12 L 21 12 C 21 12.555 20.555 13 20 13 C 19.445 13 19 12.555 19 12 L 17 12 C 17 12.555 16.555 13 16 13 C 15.445 13 15 12.555 15 12 L 13 12 C 13 12.555 12.555 13 12 13 C 11.445 13 11 12.555 11 12 L 9 12 C 9 12.555 8.555 13 8 13 C 7.445 13 7 12.555 7 12 L 5 12 C 5 12.555 4.555 13 4 13 C 3.531 13 3.20275 12.65175 3.09375 12.21875 L 5.5 9 z M 6 14.21875 C 6.531 14.69875 7.234 15 8 15 C 8.766 15 9.469 14.69875 10 14.21875 C 10.531 14.69875 11.234 15 12 15 C 12.766 15 13.469 14.69875 14 14.21875 C 14.531 14.69875 15.234 15 16 15 C 16.766 15 17.469 14.69875 18 14.21875 C 18.531 14.69875 19.234 15 20 15 C 20.766 15 21.469 14.69875 22 14.21875 C 22.531 14.69875 23.234 15 24 15 C 24.766 15 25.469 14.69875 26 14.21875 L 26 21 L 6 21 L 6 14.21875 z M 6 23 L 26 23 L 26 26 L 6 26 L 6 23 z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Store earned') }}</p>
                        <p class="font-medium text-primary-700">{{ currencyFormat($vendorsTotalEarned ?? 0.0) }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6 text-gray-500"><path d="M 20.21875 5 C 18.539063 5 17.15625 6.382813 17.15625 8.0625 C 17.15625 9.742188 18.539063 11.125 20.21875 11.125 C 21.902344 11.125 23.3125 9.742188 23.3125 8.0625 C 23.3125 6.382813 21.902344 5 20.21875 5 Z M 20.21875 7 C 20.820313 7 21.3125 7.464844 21.3125 8.0625 C 21.3125 8.660156 20.820313 9.125 20.21875 9.125 C 19.621094 9.125 19.15625 8.664063 19.15625 8.0625 C 19.15625 7.464844 19.621094 7 20.21875 7 Z M 12.9375 9 C 12.457031 9.058594 11.972656 9.28125 11.625 9.65625 L 8.25 13.3125 L 9.75 14.6875 L 13.09375 11.03125 C 13.128906 10.996094 13.175781 10.972656 13.21875 11 L 14.8125 12.0625 L 12.46875 15.3125 C 11.734375 16.34375 11.855469 17.761719 12.75 18.65625 L 16.28125 22.1875 L 13.375 28 L 15.625 28 L 18.09375 23.09375 C 18.480469 22.324219 18.328125 21.390625 17.71875 20.78125 L 14.1875 17.25 C 13.984375 17.046875 13.957031 16.703125 14.125 16.46875 L 16.46875 13.1875 L 17.28125 13.71875 L 18.875 16.125 C 19.246094 16.679688 19.863281 17 20.53125 17 L 25 17 L 25 15 L 20.53125 15 L 18.84375 12.4375 L 18.71875 12.28125 L 18.5625 12.15625 L 14.34375 9.34375 C 13.917969 9.058594 13.417969 8.941406 12.9375 9 Z M 12.0625 19.53125 L 10.59375 21 L 6 21 L 6 23 L 10.59375 23 C 11.121094 23 11.625 22.785156 12 22.40625 L 13.46875 20.9375 Z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Delivery Fee earned') }}</p>
                        <p class="font-medium text-primary-800">{{ currencyFormat($driversTotalEarned ?? 0.0) }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6 text-gray-500"><path d="M 2 7 L 2 24 L 30 24 L 30 7 L 2 7 z M 6 9 L 26 9 C 26 10.105 26.895 11 28 11 L 28 20 C 26.895 20 26 20.895 26 22 L 6 22 C 6 20.895 5.105 20 4 20 L 4 11 C 5.105 11 6 10.105 6 9 z M 16 11 C 13.789 11 12 13.016 12 15.5 C 12 17.984 13.789 20 16 20 C 18.211 20 20 17.984 20 15.5 C 20 13.016 18.211 11 16 11 z M 16 13 C 17.102 13 18 14.121 18 15.5 C 18 16.879 17.102 18 16 18 C 14.898 18 14 16.879 14 15.5 C 14 14.121 14.898 13 16 13 z M 8.5 14 C 7.672 14 7 14.672 7 15.5 C 7 16.328 7.672 17 8.5 17 C 9.328 17 10 16.328 10 15.5 C 10 14.672 9.328 14 8.5 14 z M 23.5 14 C 22.672 14 22 14.672 22 15.5 C 22 16.328 22.672 17 23.5 17 C 24.328 17 25 16.328 25 15.5 C 25 14.672 24.328 14 23.5 14 z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Total Sell') }}</p>
                        <p class="font-medium text-primary-900">{{ currencyFormat($totalSales ?? 0.0) }}</p>
                    </div>
                </div>
            </div>
            {{-- orders  --}}
            <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-3 lg:grid-cols-4">
                {{-- admin  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6"><path d="M 20.21875 5 C 18.539063 5 17.15625 6.382813 17.15625 8.0625 C 17.15625 9.742188 18.539063 11.125 20.21875 11.125 C 21.902344 11.125 23.3125 9.742188 23.3125 8.0625 C 23.3125 6.382813 21.902344 5 20.21875 5 Z M 20.21875 7 C 20.820313 7 21.3125 7.464844 21.3125 8.0625 C 21.3125 8.660156 20.820313 9.125 20.21875 9.125 C 19.621094 9.125 19.15625 8.664063 19.15625 8.0625 C 19.15625 7.464844 19.621094 7 20.21875 7 Z M 12.9375 9 C 12.457031 9.058594 11.972656 9.28125 11.625 9.65625 L 8.25 13.3125 L 9.75 14.6875 L 13.09375 11.03125 C 13.128906 10.996094 13.175781 10.972656 13.21875 11 L 14.8125 12.0625 L 12.46875 15.3125 C 11.734375 16.34375 11.855469 17.761719 12.75 18.65625 L 16.28125 22.1875 L 13.375 28 L 15.625 28 L 18.09375 23.09375 C 18.480469 22.324219 18.328125 21.390625 17.71875 20.78125 L 14.1875 17.25 C 13.984375 17.046875 13.957031 16.703125 14.125 16.46875 L 16.46875 13.1875 L 17.28125 13.71875 L 18.875 16.125 C 19.246094 16.679688 19.863281 17 20.53125 17 L 25 17 L 25 15 L 20.53125 15 L 18.84375 12.4375 L 18.71875 12.28125 L 18.5625 12.15625 L 14.34375 9.34375 C 13.917969 9.058594 13.417969 8.941406 12.9375 9 Z M 12.0625 19.53125 L 10.59375 21 L 6 21 L 6 23 L 10.59375 23 C 11.121094 23 11.625 22.785156 12 22.40625 L 13.46875 20.9375 Z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('In progress') }}</p>
                        <p class="font-medium text-primary-600">{{ $progressOrder ?? 0 }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6"
                        style="color: {{ setting('appColorTheme.deliveredColor') }}"><path d="M 23.28125 7.28125 L 11.5 19.0625 L 8.71875 16.28125 L 7.28125 17.71875 L 10.0625 20.5 L 8 22.5625 L 1.71875 16.28125 L 0.28125 17.71875 L 7.28125 24.71875 L 8 25.40625 L 8.71875 24.71875 L 11.5 21.9375 L 14.28125 24.71875 L 15 25.40625 L 15.71875 24.71875 L 31.625 8.71875 L 30.1875 7.28125 L 15 22.5625 L 12.9375 20.5 L 24.71875 8.71875 Z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Delivered/Completed') }}</p>
                        <p class="font-medium text-primary-700">{{ $completedOrder ?? 0 }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6"
                        style="color: {{ setting('appColorTheme.failedColor') }}"><path d="M 16 4 C 9.382813 4 4 9.382813 4 16 C 4 22.617188 9.382813 28 16 28 C 22.617188 28 28 22.617188 28 16 C 28 9.382813 22.617188 4 16 4 Z M 16 6 C 21.535156 6 26 10.464844 26 16 C 26 21.535156 21.535156 26 16 26 C 10.464844 26 6 21.535156 6 16 C 6 10.464844 10.464844 6 16 6 Z M 15 10 L 15 18 L 17 18 L 17 10 Z M 15 20 L 15 22 L 17 22 L 17 20 Z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Failed') }}</p>
                        <p class="font-medium text-primary-800">{{ $failedOrder ?? 0 }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-6 h-6 "><path d="M 16 3 C 8.832031 3 3 8.832031 3 16 C 3 23.167969 8.832031 29 16 29 C 23.167969 29 29 23.167969 29 16 C 29 8.832031 23.167969 3 16 3 Z M 16 5 C 22.085938 5 27 9.914063 27 16 C 27 18.726563 26.011719 21.207031 24.375 23.125 L 9.03125 7.46875 C 10.925781 5.917969 13.351563 5 16 5 Z M 7.625 8.875 L 22.96875 24.53125 C 21.074219 26.082031 18.648438 27 16 27 C 9.914063 27 5 22.085938 5 16 C 5 13.273438 5.988281 10.792969 7.625 8.875 Z"/></svg>
                    <div>
                        <p class="font-semibold">{{ __('Canceled') }}</p>
                        <p class="font-medium text-primary-900">{{ $cancelledOrder ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

    </x-baseview>

</div>
