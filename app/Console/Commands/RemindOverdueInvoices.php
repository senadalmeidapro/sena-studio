<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\OverdueInvoiceDigest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemindOverdueInvoices extends Command
{
    protected $signature = 'invoices:remind';

    protected $description = 'Mark past-due invoices overdue and send the admin a daily digest';

    public function handle(): int
    {
        Invoice::query()
            ->where('status', InvoiceStatus::Sent->value)
            ->whereNull('paid_at')
            ->whereNotNull('due_at')
            ->whereDate('due_at', '<', today())
            ->update(['status' => InvoiceStatus::Overdue->value, 'updated_at' => now()]);

        $admin = User::query()->where('is_admin', true)->orderBy('id')->first();

        if (! $admin) {
            $this->warn('No admin account is configured; overdue invoice reminders were not sent.');

            return self::SUCCESS;
        }

        $remindedOn = today()->toDateString();
        $overdue = Invoice::query()
            ->with(['engagement.client'])
            ->where('status', InvoiceStatus::Overdue->value)
            ->whereNull('paid_at')
            ->whereNotNull('due_at')
            ->whereDate('due_at', '<', today())
            ->orderBy('due_at')
            ->get();
        $newlyDue = [];

        foreach ($overdue as $invoice) {
            $inserted = DB::table('invoice_reminders')->insertOrIgnore([
                'invoice_id' => $invoice->id,
                'reminded_on' => $remindedOn,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($inserted === 1) {
                $newlyDue[] = [
                    'id' => $invoice->id,
                    'number' => $invoice->number,
                    'client' => $invoice->engagement->client->name,
                    'engagement' => $invoice->engagement->title,
                    'amount' => $invoice->amount,
                    'currency' => $invoice->currency->value,
                    'due_at' => $invoice->due_at?->toDateString(),
                ];
            }
        }

        if ($newlyDue === []) {
            $this->info('No new overdue invoices require a reminder today.');

            return self::SUCCESS;
        }

        $admin->notify(new OverdueInvoiceDigest($newlyDue, $remindedOn));
        $this->info('Sent an overdue invoice digest for '.count($newlyDue).' invoice(s).');

        return self::SUCCESS;
    }
}
