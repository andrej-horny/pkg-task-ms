<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentInspectionTemplateCondition extends Model
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
        'template_id',
        'condition_type_id',
    ];


    public function getTable(): string
    {
        return config('pkg-task-ms.table_prefix') . 'inspection_template_conditions';
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(EloquentInspectionTemplate::class, "template_id");
    }    

    public function type(): BelongsTo
    {
        return $this->belongsTo(EloquentInspectionTemplateConditionType::class, "condition_type_id");
    }       
}
