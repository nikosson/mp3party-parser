<?php

namespace App\Providers;

use App\Mp3Party\Parser\Mp3PartyParser;
use App\Mp3Party\Parser\Mp3PartyParserInterface;
use Goutte\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Mp3PartyParserInterface::class, function() {
            return new Mp3PartyParser(new Client());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
