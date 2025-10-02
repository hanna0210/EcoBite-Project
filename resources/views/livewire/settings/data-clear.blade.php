@section('title', __('Clear Data'))
<div>

    <x-baseview title="{{ __('Clear Data') }}">

        <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">


            <x-settings-item title="{{ __('Orders') }}" wireClick="confirmAction('Order','clearOrders')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </x-settings-item>

            {{-- wallet transactions --}}
            <x-settings-item title="{{ __('Wallet Transactions') }}"
                wireClick="confirmAction('WalletTransaction','clearWalletTransactions')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Reset Wallet Balance') }}"
                wireClick="confirmAction('Wallet','clearUserWalletBalance')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </x-settings-item>


            <x-settings-item title="{{ __('Products') }}" wireClick="confirmAction('Product','clearProducts')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h1.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V16a2 2 0 01-2 2H5a2 2 0 01-2-2V8zM5 8v10a2 2 0 002 2h8a2 2 0 002-2V8m-6 4h2m-2-4h2"></path>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Services') }}" wireClick="confirmAction('Service','clearServices')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6.83 1.89a2.5 2.5 0 113.54-3.54"></path>
                </svg>
            </x-settings-item>


            <x-settings-item title="{{ __('Vendors') }}" wireClick="confirmAction('Vendor','clearVendors')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
            </x-settings-item>


            <x-settings-item title="{{ __('Users') }}" wireClick="confirmAction('User','clearUsers')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Clean Drivers Record') }}"
                wireClick="confirmAction('Driver','clearDrivers')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Clean Old Media Files') }}"
                wireClick="confirmAction('Media','clearOldMedia')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h1.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V16a2 2 0 01-2 2H5a2 2 0 01-2-2V8zM5 8v10a2 2 0 002 2h8a2 2 0 002-2V8m-6 4h2m-2-4h2"></path>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Push Notifications') }}"
                wireClick="confirmAction('Push Notification','clearPushNotifications')">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Queued Jobs') }} ({{ $totalCurrentJobs ?? '--' }})"
                wireClick="confirmAction('Job','clearJobs')">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Failed Queued Jobs') }} ({{ $totalFailedJobs ?? '--' }})"
                wireClick="confirmAction('Job','clearFailedJobs')">
                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </x-settings-item>



        </div>

        <div x-data="{ open: @entangle('showCreate') }">
            <x-modal confirmText="{{ __('Clear') }}" action="{{ $actionCalled ?? '' }}">
                <p class="text-xl font-semibold">{{ __('Clear Data') }}</p>
                <p class="">{{ __('Are you sure you want to clear') }} {{ $model ?? '' }}?</p>
            </x-modal>
        </div>

    </x-baseview>

</div>
