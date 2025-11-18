<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
