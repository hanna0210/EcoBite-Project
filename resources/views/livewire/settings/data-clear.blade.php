@section('title', __('Clear Data'))
<div>

    <x-baseview title="{{ __('Clear Data') }}">

        <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">


            <x-settings-item title="{{ __('Orders') }}" wireClick="confirmAction('Order','clearOrders')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </x-settings-item>

            {{-- wallet transactions --}}
            <x-settings-item title="{{ __('Wallet Transactions') }}"
                wireClick="confirmAction('WalletTransaction','clearWalletTransactions')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Reset Wallet Balance') }}"
                wireClick="confirmAction('Wallet','clearUserWalletBalance')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
            </x-settings-item>


            <x-settings-item title="{{ __('Products') }}" wireClick="confirmAction('Product','clearProducts')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Services') }}" wireClick="confirmAction('Service','clearServices')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 19.5v-.75a7.5 7.5 0 00-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </x-settings-item>


            <x-settings-item title="{{ __('Vendors') }}" wireClick="confirmAction('Vendor','clearVendors')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </x-settings-item>


            <x-settings-item title="{{ __('Users') }}" wireClick="confirmAction('User','clearUsers')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Clean Drivers Record') }}"
                wireClick="confirmAction('Driver','clearDrivers')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Clean Old Media Files') }}"
                wireClick="confirmAction('Media','clearOldMedia')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Push Notifications') }}"
                wireClick="confirmAction('Push Notification','clearPushNotifications')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 7.1875 4.1875 C 2.890625 8.371094 2.90625 15.3125 7.1875 19.59375 L 8.59375 18.1875 C 5.074219 14.667969 5.089844 9.039063 8.59375 5.625 Z M 24.8125 4.28125 L 23.40625 5.71875 C 26.929688 9.242188 26.929688 14.757813 23.40625 18.28125 L 24.8125 19.71875 C 29.085938 15.445313 29.085938 8.554688 24.8125 4.28125 Z M 9.90625 7.1875 C 7.320313 9.773438 7.320313 14.007813 9.90625 16.59375 L 11.3125 15.1875 C 9.5 13.375 9.5 10.40625 11.3125 8.59375 Z M 22.09375 7.28125 L 20.6875 8.71875 C 22.5 10.53125 22.5 13.46875 20.6875 15.28125 L 22.09375 16.71875 C 24.679688 14.132813 24.679688 9.867188 22.09375 7.28125 Z M 16 10 C 14.894531 10 14 10.894531 14 12 C 14 12.625 14.300781 13.164063 14.75 13.53125 L 10.3125 26 L 9 26 L 9 28 L 13 28 L 13 26 L 12.40625 26 L 16 15.96875 L 19.59375 26 L 19 26 L 19 28 L 23 28 L 23 26 L 21.6875 26 L 17.25 13.53125 C 17.699219 13.164063 18 12.625 18 12 C 18 10.894531 17.105469 10 16 10 Z"/></svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Queued Jobs') }} ({{ $totalCurrentJobs ?? '--' }})"
                wireClick="confirmAction('Job','clearJobs')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 10.292969 5.292969 L 7 8.585938 L 5.707031 7.292969 L 4.292969 8.707031 L 7 11.414063 L 11.707031 6.707031 Z M 14 7 L 14 9 L 28 9 L 28 7 Z M 14 15 L 14 17 L 28 17 L 28 15 Z M 14 23 L 14 25 L 28 25 L 28 23 Z"/></svg>
            </x-settings-item>

            <x-settings-item title="{{ __('Failed Queued Jobs') }} ({{ $totalFailedJobs ?? '--' }})"
                wireClick="confirmAction('Job','clearFailedJobs')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5 text-red-500"><path d="M 13 4 L 13 20 L 19 20 L 19 4 Z M 15 6 L 17 6 L 17 18 L 15 18 Z M 13 22 L 13 28 L 19 28 L 19 22 Z M 15 24 L 17 24 L 17 26 L 15 26 Z"/></svg>
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
