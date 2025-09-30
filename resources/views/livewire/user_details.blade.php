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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 rounded-full">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-8 h-8 p-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
</svg>
                        </a>
                    @endif
                    @if (!empty($nextUserId))
                        <a href="{{ route('users.details', $nextUserId) }}"
                            class="text-white bg-gray-500 rounded-full hover:text-gray-300 hover:bg-gray-700"
                            title="{{ __('Next User') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-8 h-8 p-2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-16 "><path d="M 22.96875 4 C 22.816406 4.003906 22.65625 4.023438 22.5 4.0625 L 6.25 8.34375 C 4.9375 8.6875 4 9.890625 4 11.25 L 4 25 C 4 26.644531 5.355469 28 7 28 L 25 28 C 26.644531 28 28 26.644531 28 25 L 28 12 C 28 10.355469 26.644531 9 25 9 L 11.625 9 L 23 6 L 23 8 L 25 8 L 25 6 C 25 4.875 24.042969 3.984375 22.96875 4 Z M 7 11 L 25 11 C 25.566406 11 26 11.433594 26 12 L 26 25 C 26 25.566406 25.566406 26 25 26 L 7 26 C 6.433594 26 6 25.566406 6 25 L 6 12 C 6 11.433594 6.433594 11 7 11 Z M 22.5 17 C 21.671875 17 21 17.671875 21 18.5 C 21 19.328125 21.671875 20 22.5 20 C 23.328125 20 24 19.328125 24 18.5 C 24 17.671875 23.328125 17 22.5 17 Z"/></svg>
                </x-dashboard-card>

                {{-- loyalty point  --}}
                @if ((bool) setting('finance.enableLoyalty', false))
                    <x-dashboard-card bg="bg-primary-100" title="{{ __('Loyalty Points') }}"
                        value="{{ $loyaltyPoints ?? 0.0 }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-16 "><path d="M 9 4 L 9 7.234375 L 5.515625 5.1425781 L 4.484375 6.8574219 L 6.3886719 8 L 3 8 L 3 27 L 9 27 L 9 25 L 5 25 L 5 10 L 13.027344 10 C 13.860344 9.38 14.884 9 16 9 C 16.352 9 16.682 9.0415625 17 9.1015625 L 17 8 L 13.611328 8 L 15.515625 6.8574219 L 14.484375 5.1425781 L 11 7.234375 L 11 4 L 9 4 z M 16 11 C 14.355 11 13 12.355 13 14 C 13 14.352 13.0745 14.684 13.1875 15 L 11 15 L 11 17 L 11 27 L 29 27 L 29 17 L 29 15 L 26.8125 15 C 26.9265 14.684 27 14.352 27 14 C 27 12.355 25.645 11 24 11 C 22.25 11 21.06225 12.3275 20.28125 13.4375 C 20.17625 13.5855 20.093 13.731953 20 13.876953 C 19.906 13.731953 19.82375 13.5865 19.71875 13.4375 C 18.93675 12.3275 17.75 11 16 11 z M 16 13 C 16.625 13 17.4375 13.6715 18.0625 14.5625 C 18.2145 14.7815 18.1915 14.793953 18.3125 15.001953 L 16 15.001953 C 15.434 15.001953 15 14.567953 15 14.001953 C 15 13.435953 15.434 13 16 13 z M 24 13 C 24.566 13 25 13.434 25 14 C 25 14.566 24.566 15 24 15 L 21.6875 15 C 21.8095 14.793 21.7855 14.7805 21.9375 14.5625 C 22.5625 13.6715 23.375 13 24 13 z M 13 17 L 19 17 L 19 25 L 13 25 L 13 17 z M 21 17 L 27 17 L 27 25 L 21 25 L 21 17 z"/></svg>
                    </x-dashboard-card>
                @endif

                {{-- Orders --}}
                <x-dashboard-card bg="bg-primary-500 text-white border-primary-500" title="{{ __('Total Orders') }}"
                    value="{{ $ordersCount ?? 0 }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-16 text-white">
  <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
</svg>
                </x-dashboard-card>
                {{-- most expensive order  --}}
                @if (!(bool) setting('finance.enableLoyalty', false))
                    <x-dashboard-card bg="bg-primary-100" title="{{ __('Most Expensive Order') }}"
                        value="{{ currencyformat($expensiveOrders ?? 0) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-16 "><path d="M 24.96875 3 C 23.34375 3 22 4.34375 22 5.96875 L 22 6 L 24 6 L 24 5.96875 C 24 5.421875 24.421875 5 24.96875 5 L 25.03125 5 C 25.578125 5 26 5.421875 26 5.96875 C 26 6.285156 25.855469 6.570313 25.59375 6.75 L 23.46875 8.21875 C 22.554688 8.847656 22 9.890625 22 11 L 22 12 L 28 12 L 28 10 L 24.53125 10 C 24.570313 9.96875 24.550781 9.902344 24.59375 9.875 L 26.71875 8.40625 C 27.523438 7.851563 28 6.945313 28 5.96875 C 28 4.34375 26.65625 3 25.03125 3 Z M 4.15625 8 L 5.15625 9.53125 L 9.3125 16 L 5.15625 22.46875 L 4.15625 24 L 10.53125 24 L 10.84375 23.53125 L 12.5 20.96875 L 14.15625 23.53125 L 14.46875 24 L 20.84375 24 L 19.84375 22.46875 L 15.6875 16 L 19.84375 9.53125 L 20.84375 8 L 14.46875 8 L 14.15625 8.46875 L 12.5 11.03125 L 10.84375 8.46875 L 10.53125 8 Z M 7.8125 10 L 9.46875 10 L 11.65625 13.4375 L 12.5 14.75 L 13.34375 13.4375 L 15.53125 10 L 17.1875 10 L 13.65625 15.46875 L 13.3125 16 L 13.65625 16.53125 L 17.1875 22 L 15.53125 22 L 13.34375 18.5625 L 12.5 17.25 L 11.65625 18.5625 L 9.46875 22 L 7.8125 22 L 11.34375 16.53125 L 11.6875 16 L 11.34375 15.46875 Z"/></svg>
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
