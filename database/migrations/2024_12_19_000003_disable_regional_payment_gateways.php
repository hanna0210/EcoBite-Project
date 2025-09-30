<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DisableRegionalPaymentGateways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Disable regional payment gateways not used in Honduras
        // Keep only Stripe and PayPal active
        DB::table('payment_methods')
            ->whereIn('slug', ['paystack', 'razorpay', 'flutterwave', 'billplz', 'abitmedia', 'paytm', 'payu'])
            ->update(['is_active' => 0]);
        
        // Enable PayPal for Honduras
        DB::table('payment_methods')
            ->where('slug', 'paypal')
            ->update(['is_active' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Re-enable all payment gateways
        DB::table('payment_methods')
            ->whereIn('slug', ['paystack', 'razorpay', 'flutterwave', 'billplz', 'abitmedia', 'paytm', 'payu'])
            ->update(['is_active' => 1]);
    }
}
