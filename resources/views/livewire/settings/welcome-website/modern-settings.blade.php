<div wire:init="loadContents">
    <x-form action="saveAppSettings" :noClass="true">
        <div class="space-y-8">
            <x-input name="websiteHeaderTitle" title="{{ __('Website Header Title') }}" />
            <x-textarea name="websiteHeaderSubtitle" title="{{ __('Website Header Subtitle') }}" />
            <x-textarea name="websiteFooterBrief" title="{{ __('Website Footer Brief') }}" />
            <x-input name="websitePhoneSubtitle" title="{{ __('Website Phone Subtitle') }}" />

            <hr class="my-4" />


            {{-- social links --}}
            <div>
                <p class="font-semibold">{{ __('Social Media Links') }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <x-input name="fbLink" title="{{ __('Facebook Link') }}" />
                    <x-input name="igLink" title="{{ __('Instagram Link') }}" />
                    <x-input name="twLink" title="{{ __('Twitter Link') }}" />
                    <x-input name="yuLink" title="{{ __('Youtube Link') }}" />
                    <x-input name="liLink" title="{{ __('LinkedIn Link') }}" />
                </div>
            </div>

            <hr class="my-4" />

            {{-- banner settings --}}
            <div>
                <p class="font-semibold mb-4">{{ __('Banner Settings') }}</p>
                
                <div class="space-y-4">
                    <x-checkbox name="showBanner" title="{{ __('Show Banner') }}" description="{{ __('Enable/disable the banner section') }}" />
                    
                    <x-media-upload title="{{ __('Banner Image') }}" name="bannerImage" preview="{{ $oldBannerImage }}"
                        :photo="$oldBannerImage" :photoInfo="__('Upload banner image (recommended: 1920x400px)')" />
                    
                    <x-input name="bannerTitle" title="{{ __('Banner Title') }}" />
                    <x-textarea name="bannerSubtitle" title="{{ __('Banner Subtitle') }}" />
                    <x-input name="bannerButtonText" title="{{ __('Banner Button Text') }}" />
                    <x-input name="bannerButtonLink" title="{{ __('Banner Button Link') }}" />
                </div>
            </div>
        </div>


        <x-buttons.primary title="{{ __('Save Changes') }}" />

    </x-form>

</div>
