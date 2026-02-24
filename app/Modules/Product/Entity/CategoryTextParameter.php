<?php

namespace App\Modules\Product\Entity;

use App\Modules\Base\Entity\TextParameter;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $category_id
 * @property int $parameter_id
 *
 * @property Category $category
 * @property TextParameter $parameter
 */
class CategoryTextParameter extends Model
{

    protected $table = 'category_parameters';
    public $timestamps = false;

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function parameter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TextParameter::class, 'parameter_id', 'id');
    }
}
