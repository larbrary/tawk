# Tawk &nbsp; &nbsp;  [![Latest Version on Packagist][ico-version]][link-packagist] [![Total Downloads][ico-downloads]][link-downloads]


#### &nbsp; &nbsp; The missing integration of [tawk.to](https://www.tawk.to) chat widget for Laravel.


## Installation

Via Composer:

``` bash
$ composer require larbrary/tawk
```

Laravel 5.5+ will use the auto-discovery function but for Laravel 5.4 and lower, you will need to include the service providers & facade manually in `config/app.php`:

```php
'providers' => [
//  ...,
    Larbrary\Tawk\TawkServiceProvider::class
];

//  ...

'aliases' => [
//  ...,
    'Tawk' => Larbrary\Tawk\Facades\Tawk::class
];
```

## Config

In the `.env` file, set the Property ID. For example, if the Direct Chat Link is `https://embed.tawk.to/XXXXXXX/default`, the `.env` file should contain the following:

```ini
TAWK_TO_PROPERTY_ID=XXXXXXX
```

If you're not using the `default` chat widget, provide a Widget ID. For example, if the Direct Chat Link is `https://embed.tawk.to/XXXXXXX/5bc4ae1275bef`, the `.env` file should contain the following:


```ini
TAWK_TO_WIDGET_ID=5bc4ae1275bef
```

If you're using the `TAWK_API_KEY` ( only needed for automatically registering authenticated users with the tawk chat client ), the `.env` file should contain the following:

```ini
TAWK_TO_API_KEY=your_tawk_api_key_goes_here
```

After making changes in the `.env` file, you might need to clear the compiled views:
```shell script
php artisan view:clear
```

## Usage
Simply use `@tawk` in your blade layout file just before the body closing tag ( `</body>` ):
```blade
<html>
    <head>
<!--    ...     -->
    </head>
    <body>
<!--    ...     -->
        @tawk
    </body>
</html>
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Testing

``` shell script
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details.

## License

This package is released under the MIT license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/larbrary/tawk.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/larbrary/tawk.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/larbrary/tawk
[link-downloads]: https://packagist.org/packages/larbrary/tawk
