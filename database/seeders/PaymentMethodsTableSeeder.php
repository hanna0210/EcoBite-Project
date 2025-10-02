<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('payment_methods')->delete();

        \DB::table('payment_methods')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Cash',
                'slug' => 'cash',
                'instruction' => 'This is the method of payment upon receipt',
                'secret_key' => NULL,
                'public_key' => NULL,
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 1,
                'use_taxi' => 1,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-10 01:17:51',
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Stripe',
                'slug' => 'stripe',
                'instruction' => NULL,
                'secret_key' => 'YOUR_STRIPE_SECRET_KEY',
                'public_key' => 'YOUR_STRIPE_PUBLIC_KEY',
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 0,
                'use_taxi' => 1,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-10 01:17:54',
                'deleted_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Paystack',
                'slug' => 'paystack',
                'instruction' => NULL,
                'secret_key' => 'YOUR_PAYSTACK_SECRET_KEY',
                'public_key' => 'YOUR_PAYSTACK_PUBLIC_KEY',
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 0,
                'use_taxi' => 1,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-10 01:17:56',
                'deleted_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'RazorPay',
                'slug' => 'razorpay',
                'instruction' => NULL,
                'secret_key' => 'YOUR_RAZORPAY_SECRET_KEY',
                'public_key' => 'YOUR_RAZORPAY_PUBLIC_KEY',
                'hash_key' => 'YOUR_RAZORPAY_WEBHOOK_SECRET',
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-11-02 08:32:31',
                'deleted_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Flutterwave',
                'slug' => 'flutterwave',
                'instruction' => NULL,
                'secret_key' => 'YOUR_FLUTTERWAVE_SECRET_KEY',
                'public_key' => 'YOUR_FLUTTERWAVE_PUBLIC_KEY',
                'hash_key' => 'YOUR_FLUTTERWAVE_HASH_KEY',
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-05 20:19:19',
                'deleted_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Offline Payment',
                'slug' => 'offline',
                'instruction' => 'Send payment thru remittance.
',
                'secret_key' => '',
                'public_key' => '',
                'hash_key' => '',
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-05 20:19:05',
                'deleted_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Billplz',
                'slug' => 'billplz',
                'instruction' => NULL,
                'secret_key' => 'YOUR_BILLPLZ_SECRET_KEY',
                'public_key' => '',
                'hash_key' => '',
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-05 20:18:53',
                'deleted_at' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Wallet Balance',
                'slug' => 'wallet',
                'instruction' => NULL,
                'secret_key' => 'YOUR_WALLET_SECRET_KEY',
                'public_key' => 'YOUR_WALLET_PUBLIC_KEY',
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 1,
                'is_cash' => 1,
                'use_taxi' => 1,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-10 01:17:44',
                'deleted_at' => NULL,
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Abitmedia Cloud',
                'slug' => 'abitmedia',
                'instruction' => NULL,
                'secret_key' => 'YOUR_ABITMEDIA_SECRET_KEY',
                'public_key' => NULL,
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 0,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-05 20:19:31',
                'deleted_at' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Paypal',
                'slug' => 'paypal',
                'instruction' => NULL,
                'secret_key' => 'YOUR_PAYPAL_SECRET_KEY',
                'public_key' => 'YOUR_PAYPAL_PUBLIC_KEY',
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 0,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-09 14:24:20',
                'deleted_at' => NULL,
            ),
            10 =>
            array(
                'id' => 12,
                'name' => 'PayTm',
                'slug' => 'paytm',
                'instruction' => NULL,
                'secret_key' => '',
                'public_key' => '',
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 0,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-05 20:19:28',
                'deleted_at' => NULL,
            ),
            11 =>
            array(
                'id' => 13,
                'name' => 'PayU',
                'slug' => 'payu',
                'instruction' => NULL,
                'secret_key' => '',
                'public_key' => '',
                'hash_key' => NULL,
                'class' => NULL,
                'is_active' => 0,
                'is_cash' => 0,
                'use_taxi' => 0,
                'created_at' => '2021-01-09 12:38:10',
                'updated_at' => '2021-10-05 20:18:47',
                'deleted_at' => NULL,
            ),
        ));
    }
}