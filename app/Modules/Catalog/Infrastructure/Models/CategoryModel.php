<?php

namespace App\Modules\Catalog\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use NodeTrait;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'svg_icon', 'published', 'meta', 'parent_id'];
    protected $casts = [
        'meta' => 'array',
        'published' => 'boolean',
    ];

    // Эти поля используются для Nested Set
    protected function getLftName(): string { return '_lft'; }
    protected function getRgtName(): string { return '_rgt'; }

    public function textParameters()
    {
        return $this->belongsToMany(
            TextParameterModel::class,
            'category_text_parameter',
            'category_id',
            'text_parameter_id'
        );
    }
}
