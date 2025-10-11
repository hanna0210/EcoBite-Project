<?php

namespace App\Http\Livewire\Settings\WelcomeWebsite;

use App\Http\Livewire\BaseLivewireComponent;
use Exception;

class ModernSettings extends BaseLivewireComponent
{
    // App settings
    public $websiteHeaderTitle;
    public $websiteHeaderSubtitle;
    public $websitePhoneSubtitle;
    public $websiteFooterBrief;
    //social links
    public $fbLink;
    public $igLink;
    public $twLink;
    public $yuLink;
    public $liLink;
    //banner settings
    public $showBanner;
    public $bannerImage;
    public $oldBannerImage;
    public $bannerTitle;
    public $bannerSubtitle;
    public $bannerButtonText;
    public $bannerButtonLink;



    public function loadContents()
    {
        //
        $this->websiteHeaderTitle = setting('website.modern.websiteHeaderTitle', '');
        $this->websiteHeaderSubtitle = setting('website.modern.websiteHeaderSubtitle', '');
        $this->websitePhoneSubtitle = setting('website.modern.websitePhoneSubtitle', '');
        $this->websiteFooterBrief = setting('website.modern.websiteFooterBrief', '');
        $this->fbLink = setting('website.modern.social.fbLink', '');
        $this->igLink = setting('website.modern.social.igLink', '');
        $this->twLink = setting('website.modern.social.twLink', '');
        $this->yuLink = setting('website.modern.social.yuLink', '');
        $this->liLink = setting('website.modern.social.liLink', '');
        //banner
        $this->showBanner = setting('website.modern.showBanner', true);
        $this->oldBannerImage = setting('website.modern.bannerImage', '');
        $this->bannerTitle = setting('website.modern.bannerTitle', '');
        $this->bannerSubtitle = setting('website.modern.bannerSubtitle', '');
        $this->bannerButtonText = setting('website.modern.bannerButtonText', '');
        $this->bannerButtonLink = setting('website.modern.bannerButtonLink', '');
    }


    public function render()
    {
        return view('livewire.settings.welcome-website.modern-settings');
    }




    public function saveAppSettings()
    {

        $this->validate([
            "bannerImage" => "sometimes|nullable|image|max:3072",
        ]);

        try {

            $this->isDemo();
            
            // store new banner image
            if ($this->bannerImage) {
                $this->oldBannerImage = \Illuminate\Support\Facades\Storage::url($this->bannerImage->store('public/banners'));
            }
            
            $websiteSettings = [
                'website.modern.websiteHeaderTitle' =>  $this->websiteHeaderTitle,
                'website.modern.websiteHeaderSubtitle' =>  $this->websiteHeaderSubtitle,
                'website.modern.websiteFooterBrief' =>  $this->websiteFooterBrief,
                'website.modern.websitePhoneSubtitle' =>  $this->websitePhoneSubtitle,
                "website.modern.social" => [
                    'fbLink' =>  $this->fbLink,
                    'igLink' =>  $this->igLink,
                    'twLink' =>  $this->twLink,
                    'yuLink' =>  $this->yuLink,
                    'liLink' =>  $this->liLink,
                ],
                'website.modern.showBanner' =>  $this->showBanner ?? true,
                'website.modern.bannerImage' =>  $this->oldBannerImage,
                'website.modern.bannerTitle' =>  $this->bannerTitle,
                'website.modern.bannerSubtitle' =>  $this->bannerSubtitle,
                'website.modern.bannerButtonText' =>  $this->bannerButtonText,
                'website.modern.bannerButtonLink' =>  $this->bannerButtonLink,
            ];


            // update the site name
            setting($websiteSettings)->save();
            $this->showSuccessAlert(__("Website Settings saved successfully!"));
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Website Settings save failed!"));
        }
    }
}
