<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('single_word_or_website', function ($attribute, $value, $parameters, $validator) {
            if (!preg_match('/\s/u', $value)) {
                return true;
            } elseif (filter_var($value, FILTER_VALIDATE_URL)) {
                return true;
            } else {
                return false;
            }
        });

//        Validator::extend('single_word', function ($attribute, $value, $parameters, $validator) {
//            return is_string($value) && !preg_match('/\s/u', $value);
//        });
    }
}
