<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tasks\EloquentSubjectInterface as EloquentTaskSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tasks\EloquentAssignedToInterface as EloquentTaskAssignedToInterface;

class EloquentTask extends Model
{
    use SoftDeletes;

    protected $keyType = 'string'; // Eloquent needs string keys
    public $incrementing = false;  // ULID is not auto-increment

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'group_id',
        'subject_id',
        'subject_type',
        'assigned_to_id',
        'assigned_to_type',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'tasks';
    }    

    // public function tasks(): HasMany
    // {
    //     return $this->hasMany(Task::class, "group_id");
    // }

    public function group(): BelongsTo
    {
        return $this->belongsTo(EloquentTaskGroup::class, "group_id");
    }     

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }    

    public function getSubjectLabelAttribute(): ?string
    {
        if (! $this->subject instanceof EloquentTaskSubjectInterface) {
            return null; // safety fallback
        }

        return $this->subject->subjectLabel();
    }

    public function assignedTo(): MorphTo
    {
        return $this->morphTo();
    }       

    public function getAssignedToLabelAttribute(): ?string
    {
        if (! $this->assignedTo instanceof EloquentTaskAssignedToInterface) {
            return null; // safety fallback
        }

        return $this->assignedTo->assignedToLabel();
    }    
}
