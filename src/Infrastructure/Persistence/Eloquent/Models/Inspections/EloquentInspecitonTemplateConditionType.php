<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentInspectionTemplateConditionType extends Model
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
        'measurement_unit_id',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'inspection_template_condition_types';
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(EloquentMeasurementUnit::class, "measurement_unit_id");
    }    

    public function conditions(): HasMany
    {
        return $this->hasMany(EloquentInspectionTemplateCondition::class, "type_id");
    }     
}
