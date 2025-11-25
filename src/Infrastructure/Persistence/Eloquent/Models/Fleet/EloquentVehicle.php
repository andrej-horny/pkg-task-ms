<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet;

use Dpb\Extension\ModelState\Traits\HasStateHistory;
use Dpb\Package\Fleet\States\VehicleState;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tickets\EloquentSubjectInterface as EloquentTicketSubjectInterface;
use Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Contracts\Tasks\EloquentSubjectInterface as EloquentTaskSubjectInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;
use Spatie\ModelStates\HasStatesContract;

class EloquentVehicle extends Model implements EloquentTicketSubjectInterface, EloquentTaskSubjectInterface
{
    use SoftDeletes;
    // use HasStates;
    use HasStateHistory;

    protected $keyType = 'string'; // Eloquent needs string keys
    public $incrementing = false;  // ULID is not auto-increment

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'vin',
        // 'code',
        'model_id',
        'maintenance_group_id',
        'state',
        'construction_year',
        'warranty_initial_date',
        'warranty_months',
        'warranty_initial_km',
        'warranty_km',
        'commissioning_date',
    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['warranty_initial_date'] = 'date';
        $this->casts['state'] = config(
            'pkg-fleet.classes.vehicle_state_class',
            VehicleState::class // package default
        );

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'vehicles';
    }

    public function subjectLabel(): string
    {
        return $this->code_1;
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(EloquentVehicleModel::class, "model_id");
    }

    public function maintenanceGroup(): BelongsTo
    {
        return $this->belongsTo(EloquentMaintenanceGroup::class, "maintenance_group_id");
    }

    // public function groups(): BelongsToMany
    // {
    //     return $this->belongsToMany(
    //         VehicleGroup::class,
    //         config('pkg-fleet.table_prefix') . "group_vehicle",
    //         'vehicle_id',
    //         'group_id'
    //     );
    // }

    // public function licencePlates(): BelongsToMany
    // {
    //     return $this->belongsToMany(
    //         LicencePlate::class,
    //         config('pkg-fleet.table_prefix') . "licence_plate_history",
    //         'vehicle_id',
    //         'licence_plate_id',
    //     )
    //         ->using(LicencePlateHistory::class)
    //         ->withPivot(['date_from', 'date_to']);
    // }

    // /**
    //  * All codes that were used by this vehicle
    //  * 
    //  * @return BelongsToMany<VehicleCode, Vehicle, \Illuminate\Database\Eloquent\Relations\Pivot>
    //  */
    // public function codes(): BelongsToMany
    // {
    //     return $this->belongsToMany(
    //         VehicleCode::class,
    //         config('pkg-fleet.table_prefix') . "vehicle_code_history",
    //         'vehicle_id',
    //         'vehicle_code_id',
    //         'id',
    //         'id'
    //     )
    //         ->using(VehicleCodeHistory::class)
    //         ->withPivot(['date_from', 'date_to']);
    // }

    /**
     * Get code currently assigned to this vehicle
     * 
     * @return object|object{pivot: \Illuminate\Database\Eloquent\Relations\Pivot|VehicleCode|null}
     */
    public function getCodeAttribute(): ?EloquentVehicleCode
    {
        return $this->codes()
            ->orderByDesc('date_from')
            ->first();
    }

    // public function getLicencePlateAttribute()
    // {
    //     return $this->licencePlates()
    //         ->orderByDesc('date_from')
    //         ->first()?->code;
    // }

    // // TO DO
    // public function isUnderWarranty(): bool
    // {
    //     return true;
    // }

    // public function travelLog(): HasMany
    // {
    //     return $this->hasMany(TravelLog::class, 'vehicle_id');
    // }

    // /**
    //  * Summary of scopeByType
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @param string|array $type
    //  * @return void
    //  */
    // public function scopeByType(Builder $query, string|array $type)
    // {
    //     // cast input to array
    //     $type = is_array($type) ? $type : [$type];

    //     $query->whereHas('model', function ($q) use ($type) {
    //         $q->byType($type);
    //     });
    // }

    // /**
    //  * Summary of scopeByBrand
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @param string|array $brand
    //  * @return void
    //  */
    // public function scopeByBrand(Builder $query, string|array $brand)
    // {
    //     // cast input to array
    //     $brand = is_array($brand) ? $brand : [$brand];

    //     $query->whereHas('model', function ($q) use ($brand) {
    //         $q->byBrand($brand);
    //     });
    // }

    // /**
    //  * Summary of scopeByMaintenanceGroup
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @param string|array $maintenanceGroup
    //  * @return void
    //  */
    // public function scopeByMaintenanceGroup(Builder $query, string|array $maintenanceGroup)
    // {
    //     // cast input to array
    //     $maintenanceGroup = is_array($maintenanceGroup) ? $maintenanceGroup : [$maintenanceGroup];

    //     $query->whereHas('maintenanceGroup', function ($q) use ($maintenanceGroup) {
    //         $q->byCode($maintenanceGroup);
    //     });
    // }

    // /**
    //  * Summary of scopeByGroup
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @param string|array $group
    //  * @return void
    //  */
    // public function scopeByGroup(Builder $query, string|array $group)
    // {
    //     // cast input to array
    //     $group = is_array($group) ? $group : [$group];

    //     $query->whereHas('groups', function ($q) use ($group) {
    //         $q->byCode($group);
    //     });
    // }    
}
