<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentVehicleBrand extends Model
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
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'vehicle_brands';
    }
}
