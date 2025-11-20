<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class EloquentTicket extends Model
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
        'description',
        'type_id',
        'subject_id',
        'subject_type',
        'author_id',        
    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['date'] = 'date';
        // $this->casts['state'] = config(
        //     'pkg-tickets.classes.ticket_state_class',
        //     TicketState::class // package default
        // );

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'tickets';
    }    

    public function type(): BelongsTo
    {
        return $this->belongsTo(EloquentTicketType::class, "type_id");
    }     
    
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }    

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, "author_id");
    }      

    public function scopeByTypeCode(Builder $query, string|array $typeCode)
    {
        // cast input to array
        $typeCode = Arr::wrap($typeCode);

        $query->whereHas('type', function ($q) use ($typeCode) {
            $q->byCode($typeCode);
        });
    }    
}
