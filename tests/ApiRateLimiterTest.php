<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\Repository;
use JawadAhmed\ApiRateLimiting\ApiRateLimiter;
use PHPUnit\Framework\TestCase;

final class ApiRateLimiterTest extends TestCase
{
    public function test_it_allows_requests_until_the_limit_is_reached(): void
    {
        $service = new ApiRateLimiter(new RateLimiter(new Repository(new ArrayStore())));
        $first = $service->attempt('orders', 'user:42', 2, 60, fn () => 'first');
        $second = $service->attempt('orders', 'user:42', 2, 60, fn () => 'second');
        $blocked = $service->attempt('orders', 'user:42', 2, 60, fn () => 'never');
        self::assertTrue($first->allowed);
        self::assertSame(1, $first->remaining);
        self::assertTrue($second->allowed);
        self::assertSame(0, $second->remaining);
        self::assertFalse($blocked->allowed);
        self::assertGreaterThan(0, $blocked->retryAfter);
    }
}
