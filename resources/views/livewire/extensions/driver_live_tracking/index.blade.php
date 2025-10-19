@section('title', __('Driver Location Tracking'))
<div wire:init='loadPage'>
    <div class="flex items-center w-full mb-3 text-2xl font-semibold">
        {{ __('Driver Location Tracking') }}
    </div>

    <div class="flex items-center mb-4 justify-items-center">
        <div class="{{ setting('localeCode') == 'ar' ? 'mx-auto' : '' }}">
        </div>
        <x-buttons.plain wireClick="showAllDriversOnMap">
            {{ __('All') }}
        </x-buttons.plain>
        <div class="w-2"></div>
        <x-buttons.plain wireClick="showOnlineDriversOnMap" bgColor="bg-green-500">
            {{ __('Online Drivers') }}
        </x-buttons.plain>
        <div class="w-2"></div>
        <x-buttons.plain wireClick="showOfflineDriversOnMap" bgColor="bg-red-500">
            {{ __('Offline Drivers') }}
        </x-buttons.plain>
        <div class="w-2"></div>
        <x-buttons.plain wireClick="$set('showCreate', true)">
            {{ __('Custom') }}
        </x-buttons.plain>
        <div class="{{ setting('localeCode') == 'ar' ? '' : 'mx-auto' }}">
        </div>
        {{--  api key settings  --}}
        <x-buttons.plain wireClick="$set('showEdit', true)">
            <x-heroicon-o-cog class="w-4 h-4 mr-1" />
            Map API Key
        </x-buttons.plain>
    </div>

    <div class="w-full">
        <div id="map" class="w-full border rounded-sm border-primary-500" wire:ignore style="height: 75vh;" data-mapbox-token="{{ env('MAPBOX_API_KEY', '') }}"></div>
    </div>

    {{-- new form --}}
    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal-lg>
            <p class="text-xl font-semibold">{{ __('Drivers') }}</p>
            <livewire:extensions.driver-live-tracking.drivers-table-extension />
        </x-modal-lg>
    </div>
    {{-- edit api key form --}}
    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal action="saveJSMapApiKey">
            <p class="text-xl font-semibold">{{ __('Edit/Add Map API Key') }}</p>
            <x-input title="Map API Key" name="mapAPIKeyValue" />
        </x-modal>
    </div>

    <x-loading />



    <!-- Hidden div with content -->
    <div class="hidden" id="infoContent">
        <div style="width: 200px !important;">
            <div class="flex items-start justify-items-center space-x-4">
                <img src="" class="w-10 h-10" id="driverPhoto" />
                <div class="w-full flex items-center">
                    <div class="w-full">
                        <p class="text-semibold text-md" id="driverName"></p>
                        <p> <a href="tel:driverPhone " class="text-md underline" id="driverPhone"></a> </p>
                    </div>
                    <div>
                        <p id="statusTag"></p>
                    </div>
                </div>
            </div>
            <div id="assignedOrderInfo">
                <hr />
                <div class="flex items-center justify-between text-base font-medium">
                    <div>{{ __('Assigned Orders') }}:</div>
                    <div id="assigedOrdersTotalCount"></div>
                </div>

                <div>
                    <p class="hidden" id="orderHerfLink">{{ route('orders') }}?filters[search]=</p>
                    <a href="" class="text-md underline" id="viewAssigedOrdersLink">{{ __('View Orders') }}</a>
                </div>

            </div>
        </div>
    </div>

    {{-- scripts --}}
    @push('styles')
        {{-- Mapbox GL JS CSS --}}
        <link href='https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css' rel='stylesheet' />
    @endpush

    @push('scripts')
        {{-- Mapbox GL JS --}}
        <script src='https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js'></script>

        {{-- Firebase --}}
        <script defer src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
        <script defer src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
        <script defer src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
        
        {{-- Driver Tracking JS --}}
        <script src="{{ asset('js/extensions/driver_tracking.js') }}"></script>
    @endpush

</div>
