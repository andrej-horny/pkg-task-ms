<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentInspectionTemplate extends Model
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
        'is_periodic',
    ];

    public function getTable(): string
    {
        return config('pkg-task-ms.table_prefix') . 'inspection_templates';
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(EloquentInspection::class, "template_id");
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(EloquentInspectionTemplateCondition::class, "template_id");
    }

    public function getCondition(string $conditionCode, $conditionTypeCode)
    {
        return $this->conditions->first(function ($condition) use($conditionCode, $conditionTypeCode) {
            return $condition->code === $conditionCode && $condition->type->code === $conditionTypeCode;
        });         
    }

    public function treshold(): ?EloquentInspectionTemplateCondition
    {
        return $this->conditions()->where('code', '=', 'treshold')->first();
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            EloquentInspectionTemplateGroup::class,
            config('pkg-task-ms.table_prefix') . 'inspection_template_group',
            'template_id',
            'group_id'
        );
    }

    /**
     * Summary of scopeByGroup
     * @param \Illuminate\Contracts\Database\Eloquent\Builder $query
     * @param string|array $group
     * @return void
     */
    public function scopeByGroup(Builder $query, string|array $group)
    {
        // cast input to array
        $group = is_array($group) ? $group : [$group];

        $query->whereHas('groups', function ($q) use ($group) {
            $q->byCode($group);
        });
    }

    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereIn('code', $code);
    }
}
