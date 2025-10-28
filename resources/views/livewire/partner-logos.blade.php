@section('title', __('Partner Logos'))
<div>


    <x-baseview title="{{ __('Partner Logos') }}" :showNew="inProduction()">
        <livewire:tables.partner-logo-table />
    </x-baseview>

    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal confirmText="{{ __('Save') }}" action="save" :clickAway="false">
            <p class="text-xl font-semibold">{{ __('Create Partner Logo') }}</p>
            
            <x-input title="{{ __('Partner Name') }}" name="name" placeholder="{{ __('Enter partner name') }}" />
            
            <div>
                <x-input title="{{ __('Partner Website Link (URL)') }}" name="link" 
                         placeholder="{{ __('https://www.example.com') }}" />
                <p class="text-xs text-gray-500 mt-1 ml-1">
                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Optional: When provided, users can click the logo to visit the partner\'s website') }}
                </p>
            </div>
            
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
            
            <div>
                <x-input title="{{ __('Partner Website Link (URL)') }}" name="link" 
                         placeholder="{{ __('https://www.example.com') }}" />
                <p class="text-xs text-gray-500 mt-1 ml-1">
                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Optional: When provided, users can click the logo to visit the partner\'s website') }}
                </p>
            </div>
            
            <x-media-upload title="{{ __('Logo') }}" name="photo" preview="{{ $this->currentPhoto }}"
                :photo="$photo" :photoInfo="$photoInfo" types="PNG or JPEG" rules="image/*" />
            
            <hr class="my-2">
            <x-checkbox title="{{ __('Active') }}" name="isActive" />

            <x-form-errors />


        </x-modal>
    </div>
</div>

