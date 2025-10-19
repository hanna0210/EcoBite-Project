<?php

namespace App\Http\Livewire\Extensions\DriverLiveTracking;

use App\Http\Livewire\BaseLivewireComponent;
use App\Models\User;
use App\Traits\FirebaseAuthTrait;

class DriverLiveTrackingExtension extends BaseLivewireComponent
{

    use FirebaseAuthTrait;
    public $mapAPIKey;
    public $mapAPIKeyValue;

    public function getListeners()
    {
        return $this->listeners + [
            'showDriverLiveTracking' => 'showDriverLiveTracking',
            'showExtensions' => 'showExtensions',
            'loadDrivers' => 'loadDrivers',
            'closeDialog' => 'dismissModal',
        ];
    }

    public function mount()
    {
        //check if user has the right permission, else deny access
        if (!auth()->user()->hasPermissionTo('view-driver-tracking')) {
            abort(403, __('Unauthorized action.'));
        }

        //
        $this->mapAPIKey = setting("JSMapApiKey", setting("googleMapKey", ""));
        if (env('APP_ENV') != "production") {
            $this->mapAPIKeyValue = "XXXXXXXXXXXX";
        } else {
            $this->mapAPIKeyValue = $this->mapAPIKey;
        }
    }


    public function render()
    {
        return view('livewire.extensions.driver_live_tracking.index');
    }


    public function loadPage()
    {
        $markerIcon = asset('images/extensions/driver_tracking_delivery_boy.png');
        $this->emit("loadMap", $markerIcon);
        $data[] = setting('apiKey');
        $data[] = setting('projectId');
        $data[] = setting('messagingSenderId');
        $data[] = setting('appId');
        $data[] = $this->firebaseAuthCustomToken(\Auth::user());
        //
        $this->emit("authenticateUser", $data);
    }

    public function closeDialog()
    {
        $this->showCreate = false;
        $this->showEdit = false;
    }


    public function saveJSMapApiKey()
    {
        try {

            $this->isDemo();

            setting(
                [
                    "JSMapApiKey" => ($this->mapAPIKeyValue == "XXXXXXXXXXXX") ? $this->mapAPIKey : $this->mapAPIKeyValue,
                ]
            )->save();

            $this->showSuccessAlert(__("Settings saved successfully!"));
            return redirect()->route('driver.tracking');
        } catch (\Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Settings save failed!"));
        }
    }


    //
    public function showAllDriversOnMap()
    {
        $drivers = User::withCount("currently_assigned_orders")->whereHas('roles', function ($query) {
            return $query->where('name', "driver");
        })->get()->toArray();
        //
        $this->emit("loadDriversOnMap", $drivers);
    }

    public function showOnlineDriversOnMap()
    {
        $drivers = User::withCount("currently_assigned_orders")->whereHas('roles', function ($query) {
            return $query->where('name', "driver");
        })->where('is_online', 1)->get()->toArray();
        //
        $this->emit("loadDriversOnMap", $drivers);
    }

    public function showOfflineDriversOnMap()
    {
        $drivers = User::withCount("currently_assigned_orders")->whereHas('roles', function ($query) {
            return $query->where('name', "driver");
        })->where('is_online', 0)->get()->toArray();
        //
        $this->emit("loadDriversOnMap", $drivers);
    }
    public function loadDrivers()
    {
        $drivers = User::whereHas('roles', function ($query) {
            return $query->where('name', "driver");
        })->get()->toArray();

        $this->emit("loadDriversOnMap", $drivers);
        $this->dismissModal();
    }




    //
    public function firebaseAuthCustomToken($user)
    {

        $authToken = session('fbCustomToken');
        $authTokenExpiry = session('fbCustomTokenExpiry');

        if (empty($authToken) || empty($authTokenExpiry) || $authTokenExpiry < time()) {
            $uId = "user_id_" . $user->id . "";
            $authToken = $this->getFirebaseAuth()->createCustomToken($uId)->toString();
            session(['fbCustomToken' => $authToken]);
            session(['fbCustomTokenExpiry' => now()->addMinutes(10)->timestamp]);
        }

        return $authToken;
    }
}
