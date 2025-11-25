<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tasks;

interface EloquentSubjectInterface
{
    public function subjectLabel(): string;
}