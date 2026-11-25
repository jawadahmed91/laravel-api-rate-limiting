# Laravel API Rate Limiting


Production-oriented rate limiting for Laravel 13 APIs. This example wraps Laravel's RateLimiter so applications can apply independent limits by route scope and caller identity while returning metadata for X-RateLimit-Remaining and Retry-After headers.


## Features


- Per-user, per-IP, or per-tenant limit keys
- Independent endpoint scopes
- Remaining-attempt and retry-after metadata
- Safe hashed caller identities
- PHPUnit coverage


## Install and test


```bash
composer install
composer test
```


Use Redis or another shared cache in a multi-server deployment.


## Add this to an existing Laravel project

1. Copy `src/ApiRateLimiter.php` and `src/RateLimitResult.php` to `app/Support/RateLimiting/`.
2. Change both namespaces from `JawadAhmed\ApiRateLimiting` to `App\Support\RateLimiting`.
3. Configure a shared production cache such as Redis in `.env`, because every application server must increment the same counters.
4. Inject `ApiRateLimiter` into the controller or service that protects the operation. Laravel supplies its `Illuminate\Cache\RateLimiter` dependency automatically.
5. Call `attempt()` with a stable scope, a caller identity, the maximum attempts, and the decay period. Use a user ID, tenant ID, or IP address as the identity and never place credentials in the key.
6. Return HTTP `429` with the result's `retryAfter` value when `allowed` is false. Include `remaining` in successful responses when clients need rate-limit metadata.
7. Call `clear()` only after a trusted recovery action, such as a successful password reset or administrator unlock.
8. Copy `tests/ApiRateLimiterTest.php` into your project, update its namespace and imports, then run `php artisan test`.
9. Exercise the endpoint repeatedly and verify that the first allowed requests succeed, the next request returns `429`, and the limit resets after its decay period.

## Requirements


- PHP 8.3+
- Laravel components 13.x


## License


MIT

