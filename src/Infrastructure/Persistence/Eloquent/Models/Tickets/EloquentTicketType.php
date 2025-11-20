<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tickets;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class EloquentTicketType extends Model
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
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'ticket_types';
    }    

    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = Arr::wrap($code);

        $query->whereIn('code', $code);
    }     
}
