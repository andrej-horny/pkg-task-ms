<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class EloquentMaintenanceGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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

    // public function vehicles() : HasMany {
    //     return $this->hasMany(Vehicle::class);
    // }

    // public function vehicleType() : BelongsTo {
    //     return $this->belongsTo(VehicleType::class);
    // }

    // /**
    //  * Summary of scopeByCode
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @param string|array $code
    //  * @return void
    //  */
    // public function scopeByCode(Builder $query, string|array $code)
    // {
    //     // cast input to array
    //     $code = is_array($code) ? $code : [$code];

    //     $query->whereIn('code', $code);
    // }    

    // /**
    //  * Summary of scopeByType
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @param string|array $type
    //  * @return void
    //  */
    // public function scopeByVehicleType(Builder $query, string|array $type)
    // {
    //     // cast input to array
    //     $type = Arr::wrap($type);

    //     $query->whereHas('vehicleType', function ($q) use ($type) {
    //         $q->byCode($type);
    //     });
    // }

}
