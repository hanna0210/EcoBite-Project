@section('title', __('Vendor Details'))
<div>

    <x-baseview title="">

        @empty($selectedModel)
            <div class="p-4 border-2 rounded-xl text-primary-500 border-primary-500 opacity-20 centered">
                {{ __('No Vendor Found') }}
            </div>
        @else
            <div class="flex items-center">
                <div class="w-full space-y-1">
                    <p class='text-2xl font-semibold'> {{ $selectedModel->name }}</p>
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center space-x-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p>{{ __('Created On') }} : {{ $selectedModel->created_at->format('d M Y h:i a') }}</p>
                        </div>
                        <p>|</p>
                        <div class="flex items-center space-x-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                    <svg class="w-16 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </x-dashboard-card>


                {{-- totalPriceSold  --}}
                <x-dashboard-card bg="bg-primary-100" title="{{ __('Total Amount') }} [{{ __('Successful') }}]"
                    value="{{ currencyformat($totalPriceSold ?? 0.0) }}">
                    <svg class="w-16" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </x-dashboard-card>



            </div>

            <div class="p-4 mt-10 bg-white rounded-md shadow ">

                {{-- user order list  --}}
                <p class="pb-4 text-xl font-bold">{{ __('Orders') }}</p>
                <livewire:tables.vendor-order-table vendorId="{{ $selectedModel->id }}" />

            </div>
        @endempty
    </x-baseview>

</div>
