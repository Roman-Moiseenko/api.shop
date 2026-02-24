<?php

namespace App\Modules\Base\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property boolean $is_category
 * @property boolean $is_product
 * @property boolean $is_group
 */
class TextParameter extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_group',
        'is_product',
        'is_category',
    ];
    protected $casts = [
        'is_group' => 'boolean',
        'is_product' => 'boolean',
        'is_category' => 'boolean',
    ];

    public static function register(string $name, string $slug): self
    {
        return self::create([
            'name' => $name,
            'slug' => $slug,
        ]);
    }
}
