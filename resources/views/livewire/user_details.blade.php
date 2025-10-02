@section('title', __('User Details'))
<div>

    <x-baseview title="">

        @empty($selectedModel)
            <div class="p-4 border-2 rounded-xl text-primary-500 border-primary-500 opacity-20 centered">
                {{ __('No User Found') }}
            </div>
        @else
            <div class="flex items-center">
                <div class="w-full">
                    <p class='text-2xl font-semibold'>{{ __('User ID') }} #{{ $selectedModel->id }}</p>

                    <div class="flex items-center space-x-2 font-medium text-gray-500">
                        <p class="text-sm">{{ $selectedModel->code }}</p>
                        <p class="text-sm">{{ $selectedModel->role_name }}</p>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p>{{ __('Joined at') }} : {{ $selectedModel->created_at->format('d M Y h:i a') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @if (!empty($prevUserId))
                        <a href="{{ route('users.details', $prevUserId) }}"
                            class="text-white bg-gray-500 rounded-full hover:text-gray-300 hover:bg-gray-700"
                            title="{{ __('Prev User') }}">
                            <svg class="w-8 h-8 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    @endif
                    @if (!empty($nextUserId))
                        <a href="{{ route('users.details', $nextUserId) }}"
                            class="text-white bg-gray-500 rounded-full hover:text-gray-300 hover:bg-gray-700"
                            title="{{ __('Next User') }}">
                            <svg class="w-8 h-8 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
            {{-- wallet and Loyalty points  --}}
            <div class="grid gap-6 mt-8 md:grid-cols-2 lg:grid-cols-4">

                {{-- profile details  --}}
                <x-dashboard-card-plain bg="bg-primary-500 text-white border-primary-500">
                    <p class="text-2xl font-semibold">{{ $selectedModel->name }}</p>
                    @production
                        <p>{{ $selectedModel->email }} <span>|</span> {{ $selectedModel->phone }}</p>
                    @else
                        <p>{{ \Str::padLeft('', Str::of($selectedModel->email ?? '')->length(), '*') }} <span>|</span>
                            {{ \Str::padLeft('', Str::of($selectedModel->phone ?? '')->length(), '*') }}</p>
                    @endproduction
                </x-dashboard-card-plain>
                {{-- wallet balance  --}}
                <x-dashboard-card bg="bg-primary-100" title="{{ __('Wallet Balance') }}"
                    value="{{ currencyformat($selectedModel->wallet->balance ?? 0.0) }}">
                    <svg class="w-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 4H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H3V8h18v10zm-10-7v6h4v-6h-4z"/>
                    </svg>
                </x-dashboard-card>

                {{-- loyalty point  --}}
                @if ((bool) setting('finance.enableLoyalty', false))
                    <x-dashboard-card bg="bg-primary-100" title="{{ __('Loyalty Points') }}"
                        value="{{ $loyaltyPoints ?? 0.0 }}">
                        <svg class="w-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </x-dashboard-card>
                @endif

                {{-- Orders --}}
                <x-dashboard-card bg="bg-primary-500 text-white border-primary-500" title="{{ __('Total Orders') }}"
                    value="{{ $ordersCount ?? 0 }}">
                    <svg class="w-16 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                    </svg>
                </x-dashboard-card>
                {{-- most expensive order  --}}
                @if (!(bool) setting('finance.enableLoyalty', false))
                    <x-dashboard-card bg="bg-primary-100" title="{{ __('Most Expensive Order') }}"
                        value="{{ currencyformat($expensiveOrders ?? 0) }}">
                        <svg class="w-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 7h-9v2h9V7zm0 4h-9v2h9v-2zm0 4h-9v2h9v-2zM4 22h2v-7H4v7zm4 0h2v-7H8v7zm4 0h2v-7h-2v7zm4 0h2v-7h-2v7zM4 2h2v7H4V2zm4 0h2v7H8V2zm4 0h2v7h-2V2zm4 0h2v7h-2V2z"/>
                        </svg>
                    </x-dashboard-card>
                @endif
            </div>

            {{-- <div class="flex p-4 mt-10 space-x-0 bg-white rounded-md shadow md:space-x-6"> --}}

            <x-tab.tabview class="shadow pb-10">

                <x-slot name="header">
                    <x-tab.header tab="1" title="{{ __('Wallet Transactions') }}" />
                    <x-tab.header tab="2" title="{{ __('My Orders') }}" />
                    @if ($selectedModel->hasRole('driver'))
                        <x-tab.header tab="3" title="{{ __('Assigned Orders') }}" />
                        <x-tab.header tab="4" title="{{ __('Earning History') }}" />
                    @endif
                </x-slot>

                <x-slot name="body">
                    <x-tab.body tab="1">
                        <livewire:tables.user-wallet-transaction-table walletId="{{ $selectedModel->wallet->id ?? '' }}" />
                    </x-tab.body>
                    <x-tab.body tab="2">
                        <livewire:tables.user-order-table userId="{{ $selectedModel->id }}" />
                    </x-tab.body>
                    @if ($selectedModel->hasRole('driver'))
                        <x-tab.body tab="3">
                            <livewire:tables.driver-order-table userId="{{ $selectedModel->id }}" />
                        </x-tab.body>
                        <x-tab.body tab="4">
                            <livewire:tables.single-driver-earning-history-table userId="{{ $selectedModel->id }}" />
                        </x-tab.body>
                    @endif
                </x-slot>

            </x-tab.tabview>

            {{-- </div> --}}

        @endempty
    </x-baseview>

</div>
