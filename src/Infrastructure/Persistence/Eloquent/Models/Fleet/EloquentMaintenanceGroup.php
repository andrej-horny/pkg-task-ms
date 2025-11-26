<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet;

use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tasks\EloquentAssignedToInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class EloquentMaintenanceGroup extends Model implements EloquentAssignedToInterface
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
        'color',
        'vehicle_type_id',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'maintenance_groups';
    }

    public function assignedToLabel(): string
    {
        return $this->code;
    }

    // public function vehicles() : HasMany {
    //     return $this->hasMany(Vehicle::class);
    // }

    public function vehicleType() : BelongsTo {
        return $this->belongsTo(EloquentVehicleType::class);
    }

    /**
     * Summary of scopeByCode
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $code
     * @return void
     */
    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = Arr::wrap($code);

        $query->whereIn('code', $code);
    }    

    /**
     * Summary of scopeByType
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $type
     * @return void
     */
    public function scopeByVehicleType(Builder $query, string|array $type)
    {
        // cast input to array
        $type = Arr::wrap($type);

        $query->whereHas('vehicleType', function ($q) use ($type) {
            $q->byCode($type);
        });
    }

}
