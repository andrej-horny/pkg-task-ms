<?php

namespace Dpb\Package\TaskMS\Infrastructure\Services;

use Dpb\Package\TaskMS\Infrastructure\Contracts\IdGeneratorInterface;
use Illuminate\Support\Str;

// class LaravelIdGenerator implements IdGeneratorInterface
class LaravelIdGenerator implements IdGeneratorInterface
{
    public function generate() : string {
        return (string) Str::ulid();
    }
}
