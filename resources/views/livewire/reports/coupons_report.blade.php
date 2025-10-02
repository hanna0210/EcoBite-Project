@section('title', __('Coupon Report'))
<div>

    <x-baseview title="">
        {{-- Info cards --}}
        <div class="grid gap-6 mt-10 md:grid-cols-2 lg:grid-cols-4">

            {{-- coupons --}}
            <x-dashboard-chart>
                <livewire:livewire-pie-chart :pie-chart-model="$topCouponsChart" />
            </x-dashboard-chart>

            {{-- users --}}
            <x-dashboard-chart>
                <livewire:livewire-pie-chart :pie-chart-model="$topUsersChart" />
            </x-dashboard-chart>

            {{-- Earning --}}
            {{-- <x-dashboard-card bg="bg-blue-100" title="{{ __('TOTAL EARNINGS') }}" value="{{ setting('currency') }} {{ $totalEarnings }}">
                <svg class="w-16 text-primary-600" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </x-dashboard-card> --}}

        </div>
    </x-baseview>
    <div class="mt-12"></div>

    <x-baseview title="{{ __('Coupon Report') }}">
        <livewire:tables.reports.coupon-report-table />
    </x-baseview>

</div>
@push('scripts')
    @livewireChartsScripts
@endpush
