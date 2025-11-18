<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentTaskGroup extends Model
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
        'code',
        'title',
        'description',
        'parent_id',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'task_groups';
    }    

    // public function tasks(): HasMany
    // {
    //     return $this->hasMany(Task::class, "group_id");
    // }

    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(TicketGroup::class, "parent_id");
    // }    

    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereIn('code', $code);        
    }    
}
