<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentInspectionTemplateGroup extends Model
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
    ];

    public function getTable(): string
    {
        return config('pkg-task-ms.table_prefix') . 'inspection_template_groups';
    }

    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(
            EloquentInspectionTemplate::class,
            config('pkg-task-ms.table_prefix') . 'inspection_template_group',
            'group_id',
            'template_id'
        );
    }

    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereIn('code', $code);        
    }      
}
