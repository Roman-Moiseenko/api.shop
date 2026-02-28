<?php

namespace App\Modules\Base\Entity;

use App\Modules\Auth\Entity\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $entity_id
 * @property string $entity
 * @property int $user_id
 * @property Carbon $locked_at
 * @property Carbon $expires_at
 */
class Lock extends Model
{
    protected $fillable = [
        'entity_id',
        'entity',
        'user_id',
        'locked_at',
        'expires_at',
    ];
    protected $casts = [
        'locked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    const DURATION_SECONDS = 60;
    public $timestamps = false;

  /*  public function entityable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }
*/
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
