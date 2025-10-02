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
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Admin earned') }}</p>
                        <p class="font-medium text-primary-600">{{ currencyFormat($adminEarned ?? 0.0) }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Store earned') }}</p>
                        <p class="font-medium text-primary-700">{{ currencyFormat($vendorsTotalEarned ?? 0.0) }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5 5.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13H4V6.5l5.8-2.1c.3-.1.6-.1.8-.1 1.1 0 2.1.5 2.8 1.3l1 1.6c.2.3.5.5.9.5.1 0 .2 0 .3-.1L18 6.5V9h2V5.5l-3.4-1.2c-.3-.1-.6-.1-.8-.1-.9 0-1.7.4-2.2 1.1l-.3.5c-.2.3-.5.5-.9.5-.1 0-.2 0-.3-.1L9.8 8.9z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Delivery Fee earned') }}</p>
                        <p class="font-medium text-primary-800">{{ currencyFormat($driversTotalEarned ?? 0.0) }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
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
                    <svg class="w-6 h-6"
                        style="color: {{ setting('appColorTheme.enrouteColor') }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.5 5.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM9.8 8.9L7 23h2.1l1.8-8 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1L6 8.3V13H4V6.5l5.8-2.1c.3-.1.6-.1.8-.1 1.1 0 2.1.5 2.8 1.3l1 1.6c.2.3.5.5.9.5.1 0 .2 0 .3-.1L18 6.5V9h2V5.5l-3.4-1.2c-.3-.1-.6-.1-.8-.1-.9 0-1.7.4-2.2 1.1l-.3.5c-.2.3-.5.5-.9.5-.1 0-.2 0-.3-.1L9.8 8.9z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('In progress') }}</p>
                        <p class="font-medium text-primary-600">{{ $progressOrder ?? 0 }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg class="w-6 h-6"
                        style="color: {{ setting('appColorTheme.deliveredColor') }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Delivered/Completed') }}</p>
                        <p class="font-medium text-primary-700">{{ $completedOrder ?? 0 }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg class="w-6 h-6"
                        style="color: {{ setting('appColorTheme.failedColor') }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Failed') }}</p>
                        <p class="font-medium text-primary-800">{{ $failedOrder ?? 0 }}</p>
                    </div>
                </div>
                {{-- store  --}}
                <div class="flex items-start p-4 space-x-4 border rounded-md shadow-sm">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                        style="color: {{ setting('appColorTheme.cancelledColor') }}">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Canceled') }}</p>
                        <p class="font-medium text-primary-900">{{ $cancelledOrder ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

    </x-baseview>

</div>
