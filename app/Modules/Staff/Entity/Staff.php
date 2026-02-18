<?php

namespace App\Modules\Staff\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 */
class Staff extends Model
{

    protected $table = 'staffs';
    protected $fillable = [
        'user_id',
    ];

    public static function register(int $user_id): self
    {
        return self::create([
            'user_id' => $user_id
        ]);
    }
}
