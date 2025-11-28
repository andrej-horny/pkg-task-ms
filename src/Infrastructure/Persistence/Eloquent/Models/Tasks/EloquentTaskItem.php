<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Tasks;

use Dpb\Package\Tickets\States\TicketState;
use Dpb\Extension\ModelState\Traits\HasStateHistory;
use Dpb\Package\Tickets\States\TicketItemState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;
use Spatie\ModelStates\HasStatesContract;

class EloquentTaskItem extends Model implements HasStatesContract
{
    use SoftDeletes;
    use HasStates;
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
        'date',
        'task_id',
        'title',
        'description',
        'state',
        'group_id',
    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['date'] = 'date';
        // $this->casts['state'] = config(
        //     'pkg-tickets.classes.ticket_item_state_class',
        //     TicketItemState::class // package default
        // );

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'task_items';
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(EloquentTask::class, "task_id");
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(EloquentTaskGroup::class, "group_id");
    }    
}
