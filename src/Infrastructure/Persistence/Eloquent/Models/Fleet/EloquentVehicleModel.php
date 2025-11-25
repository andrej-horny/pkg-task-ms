<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentVehicleModel extends Model
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
        'title',
        'brand_id',
        'type_id',
        'year',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'vehicle_models';
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(EloquentVehicleBrand::class, "brand_id");
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EloquentVehicleType::class, "type_id");
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(EloquentVehicle::class, "model_id");
    }    

    /**
     * Summary of scopeByType
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $type
     * @return void
     */
    public function scopeByType(Builder $query, string|array $type)
    {
        // cast input to array
        $type = is_array($type) ? $type : [$type];

        $query->whereHas('type', function ($q) use ($type) {
            $q->byCode($type);
        });
    }

    /**
     * Summary of scopeByBrand
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $brand
     * @return void
     */
    public function scopeByBrand(Builder $query, string|array $brand)
    {
        // cast input to array
        $brand = is_array($brand) ? $brand : [$brand];

        $query->whereHas('brand', function ($q) use ($brand) {
            $q->whereIn('title', $brand);
        });
    }   
}
