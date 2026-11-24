<?php

declare(strict_types=1);

namespace JawadAhmed\ApiRateLimiting;

final readonly class RateLimitResult
{
    public function __construct(public bool $allowed, public mixed $value, public int $remaining, public int $retryAfter) {}
}
