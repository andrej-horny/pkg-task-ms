<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Inspections;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Inspections\EloquentSubjectInterface as EloquentInspectionSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet\EloquentVehicle;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\States\InspectionState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentInspection extends Model
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
        'date',
        'template_id',
        'state',
    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['date'] = 'date';
        // $this->casts['state'] = config(
        //     'pkg-inspections.classes.inspection_state_class',
        //     InspectionState::class // package default
        // );

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'inspections';
    }

    public function getSubjectLabelAttribute(): ?string
    {
        if (! $this->subject instanceof EloquentInspectionSubjectInterface) {
            return null; // safety fallback
        }

        return $this->subject->subjectLabel();
    }    

    public function template(): BelongsTo
    {
        return $this->belongsTo(EloquentInspectionTemplate::class, "template_id");
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function scopeByVehicleType(Builder $query, string|array $type)
    {
        $query->hasMorph('subject', app(EloquentVehicle::class)->getMorphClass())
            ->whereHas('subject', function ($q) use ($type) {
                $q->byType($type);
            });
    }

    public function scopeByTemplateGroup(Builder $query, string|array $group)
    {
        // cast input to array
        $group = is_array($group) ? $group : [$group];

        $query->whereHas('template', function ($q) use ($group) {
            $q->byGroup($group);
        });
    }    
    
    public function scopeByTemplate(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereHas('template', function ($q) use ($code) {
            $q->byCode($code);
        });
    }      
}
