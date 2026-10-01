<?php

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\LeadReminderDigest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class);

function reminderLead(array $attributes = []): ContactMessage
{
    $lead = ContactMessage::create(array_replace([
        'name' => 'Lead Example',
        'email' => 'lead@example.test',
        'subject' => 'Backend project',
        'message' => 'A project inquiry.',
        'status' => ContactMessage::STATUS_QUALIFYING,
        'created_at' => now()->subDay(),
    ], $attributes));

    if (array_key_exists('created_at', $attributes)) {
        $lead->forceFill(['created_at' => $attributes['created_at']])->save();
    }

    return $lead->refresh();
}

it('sends one grouped database digest and does not remind the same lead twice that day', function () {
    config(['mail.default' => 'log']);
    $admin = User::factory()->admin()->create();
    $followUp = reminderLead([
        'name' => 'Follow-up Lead',
        'follow_up_at' => now()->subHour(),
    ]);
    $noReply = reminderLead([
        'name' => 'No Reply Lead',
        'status' => ContactMessage::STATUS_NEW,
        'created_at' => now()->subDays(4),
    ]);
    reminderLead([
        'name' => 'Closed Lead',
        'status' => ContactMessage::STATUS_WON,
        'follow_up_at' => now()->subHour(),
    ]);

    Artisan::call('leads:remind');

    $notification = $admin->notifications()->sole();
    expect($notification->type)->toBe(LeadReminderDigest::class)
        ->and($notification->data['count'])->toBe(2)
        ->and(collect($notification->data['leads'])->pluck('id')->all())->toEqualCanonicalizing([$followUp->id, $noReply->id]);

    Artisan::call('leads:remind');

    expect($admin->notifications()->count())->toBe(1)
        ->and(DB::table('lead_reminders')->whereDate('reminded_on', today())->count())->toBe(2);
});

it('respects the configurable age threshold for unanswered new leads', function () {
    config(['mail.default' => 'log', 'leads.no_reply_days' => 5]);
    $admin = User::factory()->admin()->create();
    $tooRecent = reminderLead([
        'status' => ContactMessage::STATUS_NEW,
        'created_at' => now()->subDays(4),
    ]);
    $oldEnough = reminderLead([
        'status' => ContactMessage::STATUS_NEW,
        'created_at' => now()->subDays(5),
    ]);

    Artisan::call('leads:remind');

    $digest = $admin->notifications()->sole()->data;
    expect(collect($digest['leads'])->pluck('id')->all())->toBe([$oldEnough->id])
        ->and(DB::table('lead_reminders')->where('contact_message_id', $tooRecent->id)->exists())->toBeFalse();
});

it('sends nothing when no active lead is due', function () {
    config(['mail.default' => 'log']);
    $admin = User::factory()->admin()->create();
    reminderLead([
        'status' => ContactMessage::STATUS_NEW,
        'created_at' => now()->subDay(),
        'follow_up_at' => now()->addDay(),
    ]);

    Artisan::call('leads:remind');

    expect($admin->notifications()->count())->toBe(0)
        ->and(DB::table('lead_reminders')->count())->toBe(0);
});

it('emails the digest only when a non-log mailer is configured', function () {
    $admin = User::factory()->admin()->create();
    $digest = new LeadReminderDigest([], today()->toDateString());

    config(['mail.default' => 'log']);
    expect($digest->via($admin))->toBe(['database']);

    config([
        'mail.default' => 'smtp',
        'mail.from.address' => 'admin@example.test',
    ]);

    expect($digest->via($admin))->toBe(['database', 'mail']);
});

it('registers the lead reminder command in the daily scheduler', function () {
    $this->artisan('schedule:list')->expectsOutputToContain('leads:remind');
});
