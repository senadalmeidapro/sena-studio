<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\LeadReminderDigest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemindLeads extends Command
{
    protected $signature = 'leads:remind';

    protected $description = 'Send the admin a daily digest of leads requiring follow-up';

    public function handle(): int
    {
        $admin = User::query()->where('is_admin', true)->orderBy('id')->first();

        if (! $admin) {
            $this->warn('No admin account is configured; no lead reminders were sent.');

            return self::SUCCESS;
        }

        $remindedOn = today()->toDateString();
        $activeStatuses = [
            ContactMessage::STATUS_NEW,
            ContactMessage::STATUS_QUALIFYING,
            ContactMessage::STATUS_PROPOSAL,
        ];
        $thresholdDays = max(0, (int) config('leads.no_reply_days', 3));
        $staleSince = now()->subDays($thresholdDays);

        $dueFollowUps = ContactMessage::query()
            ->whereIn('status', $activeStatuses)
            ->whereNotNull('follow_up_at')
            ->where('follow_up_at', '<=', now())
            ->pluck('id');

        $noReplyLeads = ContactMessage::query()
            ->where('status', ContactMessage::STATUS_NEW)
            ->where('created_at', '<=', $staleSince)
            ->pluck('id');

        $candidates = ContactMessage::query()
            ->whereIn('id', $dueFollowUps->merge($noReplyLeads)->unique())
            ->orderBy('created_at')
            ->get(['id', 'name', 'subject', 'status', 'follow_up_at', 'created_at']);

        $newlyDueLeads = [];

        foreach ($candidates as $lead) {
            $inserted = DB::table('lead_reminders')->insertOrIgnore([
                'contact_message_id' => $lead->id,
                'reminded_on' => $remindedOn,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($inserted === 1) {
                $newlyDueLeads[] = [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'subject' => $lead->subject,
                    'status' => $lead->status,
                    'follow_up_at' => $lead->follow_up_at?->toDateTimeString(),
                    'created_at' => $lead->created_at?->toDateTimeString(),
                ];
            }
        }

        if ($newlyDueLeads === []) {
            $this->info('No new leads require a reminder today.');

            return self::SUCCESS;
        }

        $admin->notify(new LeadReminderDigest($newlyDueLeads, $remindedOn));
        $this->info('Sent a reminder digest for '.count($newlyDueLeads).' lead(s).');

        return self::SUCCESS;
    }
}
