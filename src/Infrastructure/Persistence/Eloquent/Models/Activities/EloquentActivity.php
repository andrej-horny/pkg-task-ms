<?php

namespace Dpb\Package\TaskMS\Infrastructure\Persistence\Eloquent\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EloquentActivity extends Model
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
        'status_id',
        'activity_template_id',
        'note'
    ];

    public function getTable()
    {
        return config('pkg-task-ms.table_prefix') . 'activities';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    } 

    // public function status(): BelongsTo
    // {
    //     return $this->belongsTo(EloquentActivityStatus::class, "status_id");
    // }    

    public function template(): BelongsTo
    {
        return $this->belongsTo(EloquentActivityTemplate::class, "activity_template_id");
    }               
}
