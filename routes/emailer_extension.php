<?php

//imports
use App\Http\Livewire\Extensions\Emailer\EmailerExtension;

Route::prefix('extensions')->group(function () {

    Route::group(['middleware' => ['auth']], function () {
        Route::get('emailer', EmailerExtension::class)->name('emailer.extension');
    });
    //last route

});

