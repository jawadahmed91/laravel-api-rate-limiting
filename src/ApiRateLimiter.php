<?php

declare(strict_types=1);

namespace JawadAhmed\ApiRateLimiting;

use Closure;
use Illuminate\Cache\RateLimiter;

final class ApiRateLimiter
{
    public function __construct(private readonly RateLimiter $limiter) {}

    public function attempt(string $scope, string $identity, int $maxAttempts, int $decaySeconds, Closure $callback): RateLimitResult
    {
        $key = $this->key($scope, $identity);
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return new RateLimitResult(false, null, 0, $this->limiter->availableIn($key));
        }
        $value = $callback();
        $this->limiter->hit($key, $decaySeconds);
        return new RateLimitResult(true, $value, $this->limiter->remaining($key, $maxAttempts), 0);
    }

    public function clear(string $scope, string $identity): void
    {
        $this->limiter->clear($this->key($scope, $identity));
    }

    private function key(string $scope, string $identity): string
    {
        return sprintf('api:%s:%s', $scope, hash('sha256', $identity));
    }
}
