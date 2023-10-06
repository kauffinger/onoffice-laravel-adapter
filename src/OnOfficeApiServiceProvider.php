<?php

namespace Kauffinger\OnOfficeApi;

use Illuminate\Support\Collection;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OnOfficeApiServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        $this->app->bind(OnOfficeApi::class, fn (): OnOfficeApi => new OnOfficeApi(config('onoffice.token'), config('onoffice.secret')));
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('onoffice-laravel-adapter')
            ->hasConfigFile();
    }

    public function boot()
    {
        Collection::macro('putIfNotNull', function ($key, $value) {
            if ($value != null) {
                /** @phpstan-ignore-next-line */
                $this->put($key, $value);
            }

            return $this;
        });
    }
}
