<?php

namespace App\Modules\Client\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 *
 */
class Client extends Model
{

    protected $fillable = [
        'user_id',
    ];

    public static function register(int $user_id): self
    {
        return self::create([
            'user_id' => $user_id,
        ]);
    }
}
