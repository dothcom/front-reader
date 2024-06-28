# My Package

This is a package that provides functionality for reading api data from laranews api

## Installation

To install this package, you can use Composer. Run the following command in your terminal:

```bash
composer require my-package
```

## Usage

After installing the package, you need to register the package service provider in the Laravel application's `AppServiceProvider.php` file. Add the following code to the `boot` method:

```php
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    $this->app->register(FrontReader\FrontReaderServiceProvider::class);
}
```

That's it! You can now start using the functionality provided by this package in your Laravel application.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).



