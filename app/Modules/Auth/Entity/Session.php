<?php

namespace App\Modules\Auth\Entity;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public $timestamps = false;
    public $incrementing = false;

    protected $casts = [
        'last_activity' => 'integer',
    ];

    protected $hidden = [
        'user_id',
        'payload',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
