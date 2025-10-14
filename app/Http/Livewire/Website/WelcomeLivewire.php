<?php

namespace App\Http\Livewire\Website;

use App\Models\Banner;

class WelcomeLivewire extends WebsiteBaseLivewireComponent
{

    public function render()
    {
        // Fetch active home banners
        $banners = Banner::inorder()
            ->where(function ($query) {
                $query->whereNull('vendor_type_id')
                      ->orWhere('vendor_type_id', '');
            })
            ->where('featured', true)
            ->active()
            ->get();

        $customWebsite = setting("welcomeWebsiteType", "modern") == "custom";
        if (!$customWebsite) {
            $oldWelcomeWebsite = setting("welcomeWebsiteType", "modern") == "base";
            if ($oldWelcomeWebsite) {
                return view('livewire.website.base-welcome', compact('banners'))->layout('layouts.website');
            } else {
                return view('livewire.website.modern-welcome', compact('banners'))->layout('layouts.website');
            }
        } else {
            return view('livewire.website.custom-welcome', compact('banners'))->layout('layouts.website');
        }
    }
}
