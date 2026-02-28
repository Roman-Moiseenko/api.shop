<?php

namespace App\Console\Commands\Cron;

use App\Modules\Base\Entity\Lock;
use Illuminate\Console\Command;

class ClearLockCommand extends Command
{
    protected $signature = 'lock:clear';
    protected $description = 'Очистка всех завершенных, но не снятых блокировок';
    public function handle(): void
    {
        $deleted = Lock::where('expires_at', '<', now())->delete();
        $this->info("Cleared {$deleted} expired product locks.");
    }
}
