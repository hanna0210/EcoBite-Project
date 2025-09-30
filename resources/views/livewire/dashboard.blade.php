@section('title', __('Dashboard'))
<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <x-baseview title="{{ __('Dashboard') }}">

        {{-- Info cards --}}
        <div class="grid gap-6 mt-10 md:grid-cols-2 lg:grid-cols-4">

            {{-- Orders --}}
            <x-dashboard-card bg="bg-primary-100" title="{{ __('TOTAL ORDERS') }}" value="{{ $this->totalOrders }}">
                <svg class="w-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </x-dashboard-card>

            {{-- Earning --}}
            <x-dashboard-card bg="bg-blue-100" title="{{ __('TOTAL EARNINGS') }}"
                value="{{ setting('currency') }} {{ $this->totalEarnings }}">
                <svg class="w-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
            </x-dashboard-card>
            @role('admin')
                {{-- Total Vendors --}}
                <x-dashboard-card bg="bg-red-100" title="{{ __('TOTAL VENDORS') }}" value="{{ $this->totalVendors }}">
                    <svg class="w-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12 6a6 6 0 0 1 6 6c0 1.5-.5 2.5-1.5 3.5L12 12l-4.5 3.5C6.5 14.5 6 13.5 6 12a6 6 0 0 1 6-6Z" />
                    </svg>
                </x-dashboard-card>

                {{-- Users --}}
                <x-dashboard-card bg="bg-yellow-100" title="{{ __('TOTAL Clients') }}" value="{{ $this->totalClients }}">
                    <svg class="w-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.004l-.001.225a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.225v-.004Zm14.25.004a5.625 5.625 0 0 0-11.25 0v.004l.001.225c0 .128.065.248.182.331a11.566 11.566 0 0 0 5.443 1.544c1.863 0 3.6-.523 5.443-1.544a.375.375 0 0 0 .181-.33l.001-.225v-.004Z" />
                    </svg>
                </x-dashboard-card>
            @endrole
        </div>

        {{-- Charts --}}
        <div class="grid gap-6 mt-10 lg:grid-cols-2">

            {{-- Orders --}}
            <x-dashboard-chart>
                <livewire:livewire-column-chart :column-chart-model="$this->ordersChart" />
            </x-dashboard-chart>

            @role('admin')
                {{-- Users --}}
                <x-dashboard-chart>
                    <livewire:livewire-column-chart :column-chart-model="$this->usersChart" />
                </x-dashboard-chart>
            @endrole
        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-4">

            <x-dashboard-chart>
                <livewire:livewire-column-chart :column-chart-model="$this->topSaleDaysChart" />
            </x-dashboard-chart>

            <x-dashboard-chart>
                <livewire:livewire-column-chart :column-chart-model="$this->topSaleTimingChart" />
            </x-dashboard-chart>

            @role('admin')
                <x-dashboard-chart>
                    <livewire:livewire-column-chart :column-chart-model="$this->userRolesChart" />
                </x-dashboard-chart>
            @endrole
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @role('admin')
                {{-- top selling --}}
                <div wire:init="fetchTopSellingVendors" class="space-y-2 border rounded shadow p-4">
                    <p class="text-base font-semibold text-gray-700">
                        {{ __('Top selling vendors') }}
                    </p>
                    {{-- listview --}}
                    <div class="space-y-2">
                        @foreach ($topSellingVendors ?? [] as $vendor)
                            <div>
                                <a href="{{ route('vendor.details', ['id' => $vendor->id]) }}" target="_blank">
                                    <div class="flex items-center justify-start space-x-2">
                                        <img src="{{ $vendor->logo }}" class="object-cover w-10 h-10 rounded" />
                                        <div>
                                            <p class="text-sm">{{ $vendor->name }}</p>
                                            <p class="text-xs font-light">
                                                {{ __('Total Orders') }}: {{ $vendor->successful_sales_count ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Top rated Vendors --}}
                <div wire:init="fetchTopRatedVendors" class="space-y-2 border rounded shadow p-4">
                    <p class="text-base font-semibold text-gray-700">
                        {{ __('Top rated Vendors') }}
                    </p>
                    {{-- listview --}}
                    <div class="space-y-2">
                        @foreach ($topRatedVendors ?? [] as $vendor)
                            <div>
                                <a href="{{ route('vendor.details', ['id' => $vendor->id]) }}" target="_blank">
                                    <div class="flex items-center justify-start space-x-2">
                                        <img src="{{ $vendor->logo }}" class="object-cover w-10 h-10 rounded" />
                                        <div class="">
                                            <p class="text-sm">{{ $vendor->name }}</p>
                                            <p class="text-xs font-light flex space-x-2">
                                                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                </svg>
                                                {{ $vendor->rating ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Top customers --}}
                <div wire:init="fetchTopCustomers" class="space-y-2 border rounded shadow p-4">
                    <p class="text-base font-semibold text-gray-700">
                        {{ __('Top Buying Customers') }}
                    </p>
                    {{-- listview --}}
                    <div class="space-y-2">
                        @foreach ($topCustomers ?? [] as $user)
                            <div>
                                <a href="{{ route('users.details', ['id' => $user->id]) }}" target="_blank">
                                    <div class="flex items-center justify-start space-x-2">
                                        <img src="{{ $user->photo }}" class="object-cover w-10 h-10 rounded" />
                                        <div class="">
                                            <p class="text-sm">{{ $user->name }}</p>
                                            {{-- quick analysis --}}
                                            <div class="flex space-x-2 items-center justify-center">
                                                <p class="text-xs font-light flex space-x-2">
                                                    {{ __('Total Orders') }}:
                                                    {{ $user->orders_count ?? 0 }}
                                                </p>
                                                <span class="text-xs">|</span>
                                                <p class="text-xs font-light flex space-x-2">
                                                    {{ __('Successful') }}:
                                                    {{ $user->successful_orders_count ?? 0 }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Top selling products --}}
                <div wire:init="fetchTopSellingProducts" class="space-y-2 border rounded shadow p-4">
                    <p class="text-base font-semibold text-gray-700">
                        {{ __('Top selling Products') }}
                    </p>
                    {{-- listview --}}
                    <div class="space-y-2">
                        @foreach ($topSellingProducts ?? [] as $product)
                            <div>
                                <a href="{{ route('product.details', ['id' => $product->id]) }}" target="_blank">
                                    <div class="flex items-center justify-start space-x-2">
                                        <img src="{{ $product->photo }}" class="object-cover w-10 h-10 rounded" />
                                        <div class="">
                                            <p class="text-sm">{{ $product->name }}</p>
                                            {{-- quick analysis --}}
                                            <div class="flex space-x-2 items-center justify-center">
                                                <p class="text-xs font-light flex space-x-2">
                                                    {{ __('Orders') }}:
                                                    {{ $product->successful_sales_count ?? 0 }}
                                                </p>
                                                <span class="text-xs">|</span>
                                                <p class="text-xs font-light flex space-x-2">
                                                    {{ __('Units') }}:
                                                    {{ $product->successful_sales_sum_quantity ?? 0 }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- my Top selling products --}}
                <div wire:init="fetchMyTopSellingProducts" class="space-y-2 border rounded shadow p-4">
                    <p class="text-base font-semibold text-gray-700">
                        {{ __('Top selling Products') }}
                    </p>
                    {{-- listview --}}
                    <div class="space-y-2">
                        @foreach ($myTopSellingProducts ?? [] as $product)
                            <div>
                                <a href="{{ route('product.details', ['id' => $product->id]) }}" target="_blank">
                                    <div class="flex items-center justify-start space-x-2">
                                        <img src="{{ $product->photo }}" class="object-cover w-10 h-10 rounded" />
                                        <div class="">
                                            <p class="text-sm">{{ $product->name }}</p>
                                            {{-- quick analysis --}}
                                            <div class="flex space-x-2 items-center justify-center">
                                                <p class="text-xs font-light flex space-x-2">
                                                    {{ __('Orders') }}:
                                                    {{ $product->successful_sales_count ?? 0 }}
                                                </p>
                                                <span class="text-xs">|</span>
                                                <p class="text-xs font-light flex space-x-2">
                                                    {{ __('Units') }}:
                                                    {{ $product->successful_sales_sum_quantity ?? 0 }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endrole

        </div>




        {{-- space --}}
        <div class="h-20"></div>

    </x-baseview>
</div>
@push('scripts')
    @livewireChartsScripts
@endpush
