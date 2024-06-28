<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $paystackData = DB::table('paystack_data')->latest()->first();

        // Configuration array
        $config = [
            /**
             * Public Key From Paystack Dashboard
             */
            'publicKey' => $paystackData ? $paystackData->public_key : getenv('PAYSTACK_PUBLIC_KEY'),

            /**
             * Secret Key From Paystack Dashboard
             */
            'secretKey' => $paystackData ? $paystackData->client_secret : getenv('PAYSTACK_SECRET_KEY'),

            /** 
             * Paystack Payment URL
             */
            'paymentUrl' => getenv('PAYSTACK_PAYMENT_URL'),

            /**
             * Optional email address of the merchant
             */
            'merchantEmail' => getenv('MERCHANT_EMAIL'),
        ];

        // Merge the configuration with existing configuration
        config()->set('paystack', $config);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);
    }
}
