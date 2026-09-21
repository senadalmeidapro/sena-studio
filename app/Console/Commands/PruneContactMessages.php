<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use Illuminate\Console\Command;

class PruneContactMessages extends Command
{
    protected $signature = 'contact-messages:prune {--dry-run : Count records without deleting them}';

    protected $description = 'Supprime les messages de contact arrivés à échéance.';

    public function handle(): int
    {
        $years = max(1, (int) config('privacy.contact_message_retention_years', 3));
        $cutoff = now()->subYears($years);
        $query = ContactMessage::query()->where('created_at', '<', $cutoff);
        $count = $query->count();

        if ($this->option('dry-run')) {
            $this->info("Messages expirés : {$count} (aucune suppression). ");

            return self::SUCCESS;
        }

        $query->delete();
        $this->info("Messages supprimés : {$count}.");

        return self::SUCCESS;
    }
}
