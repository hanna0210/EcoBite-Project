<?php

//imports
use App\Http\Livewire\Extensions\DriverLiveTracking\DriverLiveTrackingExtension;

Route::prefix('extensions')->group(function () {

    Route::group(['middleware' => ['auth']], function () {
        Route::get('driver/tracking', DriverLiveTrackingExtension::class)->name('driver.tracking');
    });
    //last route

});
