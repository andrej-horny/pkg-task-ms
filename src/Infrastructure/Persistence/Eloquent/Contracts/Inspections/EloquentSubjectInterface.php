<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Inspections;

interface EloquentSubjectInterface
{
    public function subjectLabel(): string;
}