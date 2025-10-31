@section('title', __('Taxi Zones'))
<div>


    <x-baseview title="{{ __('Taxi Zones') }}" :showNew="true">
        <livewire:tables.taxi-zone-table />
    </x-baseview>


    {{-- new form --}}
    <div x-data="{ open: @entangle('showCreate') }" x-init="$watch('open', value => { if(value) { setTimeout(() => initMap(), 300); } })">
        <x-modal-lg confirmText="{{ __('Save') }}" action="save" :clickAway="false">
            <p class="text-xl font-semibold">{{ __('New Delivery Zone') }}</p>
            <x-input title="{{ __('Name') }}" name="name" placeholder="" />
            <div wire:ignore id="map" class="my-4 h-72" data-mapbox-token="{{ env('MAPBOX_API_KEY', '') }}"></div>
            <x-textarea title="{{ __('Coordinates') }}" name="coordinates" placeholder="" disable="true" />
            <x-checkbox title="{{ __('Active') }}" name="is_active" :defer="false" />
        </x-modal-lg>
    </div>

    {{-- edit form --}}
    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal-lg confirmText="{{ __('Save') }}" action="update" :clickAway="false">
            <p class="text-xl font-semibold">{{ __('Update Delivery Zone') }}</p>
            <x-input title="{{ __('Name') }}" name="name" placeholder="" />
            <div wire:ignore id="editMap" class="my-4 h-72" data-mapbox-token="{{ env('MAPBOX_API_KEY', '') }}"></div>
            <x-textarea title="{{ __('Coordinates') }}" name="coordinates" placeholder="" disable="true" />
            <x-checkbox title="{{ __('Active') }}" name="is_active" :defer="false" />
        </x-modal-lg>
    </div>


</div>


@push('styles')
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.css" type="text/css">
@endpush

@push('scripts')
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.js"></script>
    <script src="{{ asset('js/delivery-zone.js') }}"></script>
@endpush
