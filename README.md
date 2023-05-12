# A joyful way to interact with the onOffice API using Laravel and Saloon.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kauffinger/onoffice-laravel-adapter.svg?style=flat-square)](https://packagist.org/packages/kauffinger/onoffice-laravel-adapter)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kauffinger/onoffice-laravel-adapter/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kauffinger/onoffice-laravel-adapter/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kauffinger/onoffice-laravel-adapter/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kauffinger/onoffice-laravel-adapter/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kauffinger/onoffice-laravel-adapter.svg?style=flat-square)](https://packagist.org/packages/kauffinger/onoffice-laravel-adapter)

This is a package meant to make interacting with the onOffice API enjoyable and easy. We try our best to make all rules from the API as explicit as possible in code. This means you shouldn't be able to create invalid requests.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/onoffice-laravel-adapter.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/onoffice-laravel-adapter)

## Installation

You can install the package via composer:

```bash
composer require kauffinger/onoffice-laravel-adapter
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="onoffice-laravel-adapter-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
$request = new OnOfficeApiRequest();
$request->addAction(
    Action::read()
        ->address()
        ->formatOutput()
        ->outputInLanguage(Language::German)
        ->addMobileUrl()
        ->fieldsToRead('phone', 'mobile')
        ->setListLimit(200)
);

$response = $api->send($request);
```

Or, if you like your code even cleaner, how about this:

```php
$request = OnOfficeApiRequest::with(
    Action::read()
        ->task()
        ->fieldsToRead('Eintragsdatum', 'modified')
        ->setRelatedEstateId(2)
        ->setRelatedProjectId(1)
        ->setListLimit(200)
);

$response = OnOfficeApi::for(
    config('onoffice.token'), config('onoffice.secret')
)
    ->send($request);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Konstantin Auffinger](https://github.com/kauffinger)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
