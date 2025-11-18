<?php

namespace Dpb\Package\TaskMS\Infrastructure\Services;

use Illuminate\Support\Str;

// class LaravelIdGenerator implements IdGeneratorInterface
class LaravelIdGenerator
{
    public function generate() : string {
        return (string) Str::ulid();
    }
}
