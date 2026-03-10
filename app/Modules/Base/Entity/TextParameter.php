<?php

namespace App\Modules\Base\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property array $type_is
 * @property boolean $is_category
 * @property boolean $is_product
 * @property boolean $is_group
 */
class TextParameter extends Model
{

    const array TYPE_IS = [
        'is_category',
        'is_group',
        'is_product'
    ];

    public $timestamps = false;
    protected $attributes = [
        'type_is' => '[]'
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type_is',
    ];
    protected $casts = [
        'type_is' => 'array',
    ];

    public static function register(string $name, string $slug): self
    {
        return self::create([
            'name' => $name,
            'slug' => $slug,
        ]);
    }
}
