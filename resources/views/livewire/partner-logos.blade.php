@section('title', __('Partner Logos'))
<div>


    <x-baseview title="{{ __('Partner Logos') }}" :showNew="inProduction()">
        <livewire:tables.partner-logo-table />
    </x-baseview>

    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal confirmText="{{ __('Save') }}" action="save" :clickAway="false">
            <p class="text-xl font-semibold">{{ __('Create Partner Logo') }}</p>
            
            <x-input title="{{ __('Partner Name') }}" name="name" placeholder="{{ __('Enter partner name') }}" />
            
            <x-media-upload title="{{ __('Logo') }}" name="photo" :photo="$photo" :photoInfo="$photoInfo"
                types="PNG or JPEG" rules="image/*" />
            
            <hr class="my-2">
            <x-checkbox title="{{ __('Active') }}" name="isActive" />

            <x-form-errors />

        </x-modal>
    </div>

    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal confirmText="{{ __('Update') }}" action="update" :clickAway="false">

            <p class="text-xl font-semibold">{{ __('Edit Partner Logo') }}</p>
            
            <x-input title="{{ __('Partner Name') }}" name="name" placeholder="{{ __('Enter partner name') }}" />
            
            <x-media-upload title="{{ __('Logo') }}" name="photo" preview="{{ $this->currentPhoto }}"
                :photo="$photo" :photoInfo="$photoInfo" types="PNG or JPEG" rules="image/*" />
            
            <hr class="my-2">
            <x-checkbox title="{{ __('Active') }}" name="isActive" />

            <x-form-errors />


        </x-modal>
    </div>
</div>

