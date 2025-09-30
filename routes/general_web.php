<?php

use App\Http\Controllers\API\AuthRedirectController;
use App\Http\Livewire\InAppSupportPageLivewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMSPageController;
//
use App\Http\Livewire\Payment\OrderPaymentLivewire;
use App\Http\Livewire\Payment\OrderPaymentCallbackLivewire;
use App\Http\Livewire\Payment\PaymentProcessedLivewire;
use App\Http\Livewire\Payment\WalletTopUpLivewire;
use App\Http\Livewire\Payment\WalletTopUpFailureLivewire;
use App\Http\Livewire\Payment\WalletTopUpCallbackLivewire;
use App\Http\Livewire\Payment\SubscribeCallbackLivewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function () {


    //redirect api to authenticated web route
    Route::get('/auth/redirect', [AuthRedirectController::class, 'index'])->name('web.auth.redirect');

    // Pages
    Route::get('privacy/policy', function () {
        $content = view('layouts.includes.privacy')->render();
        $title = __("Privacy Policy");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('privacy');

    Route::get('pages/contact', function () {
        $content = view('layouts.includes.contact')->render();
        $title = __("Contact Info");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('contact');

    Route::get('pages/terms', function () {
        $content = view('layouts.includes.terms')->render();
        $title = __("Terms & Condition");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('terms');

    Route::get('pages/shipping/terms', function () {
        $content = view('layouts.includes.shipping-terms')->render();
        $title = __("Delivery/Shipping Policy");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('shipping.terms');

    Route::get('pages/refund/terms', function () {
        $content = view('layouts.includes.refund-terms')->render();
        $title = __("Refund Policy");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('refund.terms');

    Route::get('pages/cancel/terms', function () {
        $content = view('layouts.includes.cancel-terms')->render();
        $title = __("Cancellation Policy");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('cancel.terms');


    Route::get('pages/payment/terms', function () {
        $content = view('layouts.includes.payment-terms')->render();
        $title = __("Payment Terms & Condition");
        return view('layouts.includes.base', compact('content', 'title'));
    })->name('payment.terms');
    //
    Route::get('support/chat', InAppSupportPageLivewire::class)->name('support.chat');
    Route::get('cms/{slug}', [CMSPageController::class, 'index'])->name('cms.page');


    //Unauth routes
    //START-Description rendering
    Route::get('product/{id}/description', function ($id) {
        $product = \App\Models\Product::findOrFail($id);
        return view('product_description', compact('product'));
    })->name('product.description.render');
    Route::get('service/{id}/description', function ($id) {
        $service = \App\Models\Service::findOrFail($id);
        return view('service_description', compact('service'));
    })->name('service.description.render');
    Route::get('vendor/{id}/description', function ($id) {
        $vendor = \App\Models\Vendor::findOrFail($id);
        return view('vendor_description', compact('vendor'));
    })->name('vendor.description.render');
    //END-Description rendering


    //
    Route::get('payment/processed', PaymentProcessedLivewire::class)->name('payment.processed');
    Route::get('order/payment', OrderPaymentLivewire::class)->name('order.payment');
    Route::get('order/payment/callback', OrderPaymentCallbackLivewire::class)->name('payment.callback');
    //Wallet
    Route::get('wallet/topup/payment/{code}', WalletTopUpLivewire::class)->name('wallet.topup');
    // Route::get('wallet/topup/failed', WalletTopUpFailureLivewire::class)->name('wallet.topup.failed');
    Route::get('wallet/topup/failed/{code}', WalletTopUpFailureLivewire::class)->name('wallet.topup.failed');
    // Route::get('wallet/topup/callback', WalletTopUpCallbackLivewire::class)->name('wallet.topup.callback');
    Route::get('wallet/topup/callback/{code}', WalletTopUpCallbackLivewire::class)->name('wallet.topup.callback');

    //Subscription callback
    // Route::get('subscription/payment/callback', SubscribeCallbackLivewire::class)->name('subscription.callback');
    Route::get('subscription/payment/callback/{code}', SubscribeCallbackLivewire::class)->name('subscription.callback');
});
