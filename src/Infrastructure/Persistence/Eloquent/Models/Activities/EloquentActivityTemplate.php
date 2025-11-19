<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentActivityTemplate extends Model
{
    use SoftDeletes;
    protected $keyType = 'string'; // Eloquent needs string keys
    public $incrementing = false;  // ULID is not auto-increment
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'activity_templates';
    }

    public function activities(): HasMany
    {
        return $this->hasMany(EloquentActivity::class, "activity_template_id");
    }

    public function templateGroup(): BelongsTo
    {
        return $this->belongsTo(EloquentActivityTemplateGroup::class, "template_group_id");
    }
}
