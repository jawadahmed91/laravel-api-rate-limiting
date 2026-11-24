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

## Requirements

- PHP 8.3+
- Laravel components 13.x

## License

MIT
