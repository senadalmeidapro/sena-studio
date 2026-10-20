<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use App\Notifications\NewContactMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        $deleted = 0;

        $query->orderBy('id')->chunkById(500, function ($messages) use (&$deleted): void {
            $ids = $messages->modelKeys();
            $messageIds = array_map('strval', $ids);

            DB::table('notifications')
                ->where('type', NewContactMessage::class)
                ->whereIn('data->message_id', $messageIds)
                ->delete();

            $deleted += ContactMessage::query()->whereKey($ids)->delete();
        });
        $this->info("Messages supprimés : {$count}.");

        return self::SUCCESS;
    }
}
