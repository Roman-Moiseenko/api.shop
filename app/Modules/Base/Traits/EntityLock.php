<?php

namespace App\Modules\Base\Traits;

use App\Modules\Base\Entity\Lock;

/**
 * @property Lock $lock
 */
class EntityLock
{
    public function lock()
    {
        return $this->morphOne(Lock::class, 'entityable');
    }

}
