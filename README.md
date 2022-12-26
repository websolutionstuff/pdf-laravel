# Laravel 6-7-8-9 HTML To PDF Converter

[![Latest Stable Version](http://poser.pugx.org/websolutionstuff/pdf-laravel/v)](https://packagist.org/packages/websolutionstuff/pdf-laravel) [![Total Downloads](http://poser.pugx.org/websolutionstuff/pdf-laravel/downloads)](https://packagist.org/packages/websolutionstuff/pdf-laravel) [![License](http://poser.pugx.org/websolutionstuff/pdf-laravel/license)](https://packagist.org/packages/websolutionstuff/pdf-laravel)

## Installation

The Laravel PDF service provider can be installed via [composer](http://getcomposer.org) by requiring the `websolutionstuff/pdf-laravel` package in your project's `composer.json` file.

```
composer require websolutionstuff/pdf-laravel
```

or

Laravel 5.5+ will use the auto-discovery function.

```json
{
    "require": {
        "websolutionstuff/pdf-laravel": "^1.0"
    }
}
```

If you don't use auto-discovery you will need to include the service provider and facade in the `config/app.php` file.


```php
'providers' => [
    ...
    ...
    Websolutionstuff\PDF\ServiceProvider::class
]

//...

'aliases' => [
    ...
    ..
    'PDF' => Websolutionstuff\PDF\Facades\PDF::class
]
```

## Lumen

In the Lumen add the following lines:

```php
$app->register(Websolutionstuff\PDF\ServiceProvider::class);
class_alias(Websolutionstuff\PDF\Facades\PDF::class, 'PDF');
```

## Example

Let's see some beautiful examples.

```php
use PDF; // at the top of the file

  PDF::SetTitle('Websolutionstuff PDF File');
  PDF::AddPage();
  PDF::Write(0, 'Websolutionstuff PDF File Generate');
  PDF::Output('websolutionstuff.pdf');
```

another example for generating multiple PDF's

```php
use PDF; // at the top of the file

  for ($i = 0; $i < 5; $i++) {
    PDF::SetTitle('Websolutionstuff PDF File'.$i);
    PDF::AddPage();
    PDF::Write(0, 'Websolutionstuff PDF File Generate'.$i);
    PDF::Output(public_path('websolutionstuff' . $i . '.pdf'), 'F');
    PDF::reset();
  }
```

## Configuration

PDF-Laravel comes with some basic configuration.
If you want to override the defaults, you can publish the config, like so:

    php artisan vendor:publish --provider="Websolutionstuff\PDF\ServiceProvider"

Now access `config/pdf.php` to customize.

 * use_original_header is to used the original `Header()` from PDF.
    * Please note that `PDF::setHeaderCallback(function($pdf){})` overrides this settings.
 * use_original_footer is to used the original `Footer()` from PDF.
    * Please note that `PDF::setFooterCallback(function($pdf){})` overrides this settings.

## Header/Footer helpers

You can use for Header and Footer.

* `PDF::setHeaderCallback(function($pdf){})` 
* `PDF::setFooterCallback(function($pdf){})`