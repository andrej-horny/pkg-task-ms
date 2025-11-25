<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Fleet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentVehicleCode extends Model
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
        'date_from',
        'date_to',

    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['date_from'] = 'date';
        $this->casts['date_to'] = 'date';

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'vehicle_codes';
    }
}
