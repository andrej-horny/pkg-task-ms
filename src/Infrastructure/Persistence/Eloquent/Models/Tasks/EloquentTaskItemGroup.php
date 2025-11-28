<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentTaskItemGroup extends Model
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
        'task_group_id',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'task_item_groups';
    }    

    public function taskItems(): HasMany
    {
        return $this->hasMany(EloquentTaskItem::class, "group_id");
    }

    public function taskGroup(): BelongsTo
    {
        return $this->belongsTo(EloquentTaskGroup::class, "task_group_id");
    }    
}
