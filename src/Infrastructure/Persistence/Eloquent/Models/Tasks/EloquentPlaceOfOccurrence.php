<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class EloquentPlaceOfOccurrence extends Model
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
        'uri',
        'title',
        'description',
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'places_of_occurrence';
    }     

    public function scopeByUri(Builder $query, string|array $uri)
    {
        // cast input to array
        $uri = Arr::wrap($uri);

        $query->whereIn('uri', $uri);        
    }    
}
