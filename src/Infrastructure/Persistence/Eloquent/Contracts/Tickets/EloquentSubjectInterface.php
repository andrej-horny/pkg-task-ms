<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tickets;

interface EloquentSubjectInterface
{
    public function subjectLabel(): string;
}