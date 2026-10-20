<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrunePrivacyConsents extends Command
{
    protected $signature = 'privacy-consents:prune {--dry-run : Count records without deleting them}';

    protected $description = 'Remove consent records older than six months.';

    public function handle(): int
    {
        $query = DB::table('privacy_consents')->where('created_at', '<', now()->subMonths(6));
        $count = $query->count();

        if ($this->option('dry-run')) {
            $this->info("Consent records expired: {$count} (no records deleted).");

            return self::SUCCESS;
        }

        $query->delete();
        $this->info("Consent records deleted: {$count}.");

        return self::SUCCESS;
    }
}
