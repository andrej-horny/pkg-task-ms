<?php

namespace Dpb\Package\TaskMS\Infrastructure\Contracts;

use Illuminate\Support\Str;

// class LaravelIdGenerator implements IdGeneratorInterface
interface IdGeneratorInterface
{
    public function generate() : string;
}
