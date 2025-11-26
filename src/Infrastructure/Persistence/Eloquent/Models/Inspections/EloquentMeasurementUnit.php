<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentMeasurementUnit extends Model
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

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'measurement_units';
    }

    public function conditionTypes(): HasMany
    {
        return $this->hasMany(EloquentInspectionTemplateConditionType::class, "measurement_unit_id");
    }    
}
