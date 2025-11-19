<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentActivityTemplateGroup extends Model
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
        'parent_id',
        'code',
        'title',
        'description',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'activity_template_groups';
    }    

    public function templates(): HasMany
    {
        return $this->hasMany(EloquentActivity::class, "template_group_id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(EloquentActivityTemplateGroup::class, "parent_id");
    }
}
