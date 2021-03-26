![Laravel Ghost Banner](https://banners.beyondco.de/Laravel%20Ghost.png?theme=dark&packageManager=composer+require&packageName=messerli90%2Flaravel-ghost&pattern=architect&style=style_2&description=Bring+your+Ghost+blog+to+Laravel&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg&widths=400&heights=auto)

# Laravel wrapper for the Ghost blogging API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/messerli90/laravel-ghost.svg?style=flat-square)](https://packagist.org/packages/messerli90/laravel-ghost)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/messerli90/laravel-ghost/run-tests?label=tests)](https://github.com/messerli90/laravel-ghost/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/messerli90/laravel-ghost/Check%20&%20fix%20styling?label=code%20style)](https://github.com/messerli90/laravel-ghost/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/messerli90/laravel-ghost.svg?style=flat-square)](https://packagist.org/packages/messerli90/laravel-ghost)

A fluent wrapper for the [Ghost Content API](https://ghost.org/docs/content-api/)

🚧 Work in Progress 🚧

## Example

```php
$post = Ghost::posts()->with('authors')->fromSlug('welcome');

$tags = Ghost::tags()->all();
```

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require messerli90/laravel-ghost
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Messerli90\Ghost\GhostServiceProvider" --tag="ghost-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * The API version of your Ghost blog
     *
     * Read about Ghost API Versioning in their docs:
     * https://ghost.org/docs/faq/api-versioning/
     */
    'ghost_api_version' => env("GHOST_API_VERSION", 4),

    /**
     * Your admin domain can be different to your main domain.
     * All Ghost(Pro) blogs have a `.ghost.io` domain
     * as their admin domain and require https.
     */
    'admin_domain' => env('GHOST_ADMIN_DOMAIN', "https://{admin_domain}"),

    /**
     * The Content API URL and key can be obtained by creating a new
     * Custom Integration under the Integrations screen in Ghost Admin.
     */
    'key' => env('GHOST_API_KEY', ''),

    /**
     * Optionally, cache records when they are returned.
     */
    'cache' => [
        /**
         * Cache returned records
         * Set to false if you want to handle caching yourself
         */
        'cache_records' => false,

        /**
         * Prefix key used to save to cache
         * Ex. ghost_posts
         */
        'cache_prefix' => 'ghost_',

        /**
         * How long until cache expires
         * Accepts int in seconds, or DateTime instance
         */
        'ttl' => 60 * 60,
    ]
];
```

## Usage

```php
// Using the facade
Ghost::posts()->all();

// or
$ghost = new Ghost($content_key, $domain, string $version);
$ghost->posts()->all();
```

The API for `posts`, `authors`, `tags`, and `pages` is similiar and can be used with the following methods:

```php
// All posts (or other resource)
Ghost::posts()->all();
Ghost::authors()->all();
```

Build your request

```php
Ghost::posts()
    ->with('authors', 'tags')
    ->fields('title', 'slug', 'html')
    ->limit(20)
    ->page(2)
    ->orderBy('title')
    ->get();
```

## Experimental

#### Resource Caching

Automatically cache returned records for a defined time.

Includes `ghost:cache` artisan command that can be scheduled to periodically repopulate cache with new posts.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Michael Messerli](https://github.com/messerli90)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
