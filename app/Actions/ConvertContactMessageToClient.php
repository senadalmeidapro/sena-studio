<?php

namespace App\Actions;

use App\Enums\Currency;
use App\Enums\EngagementPricingModel;
use App\Enums\EngagementStatus;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Engagement;
use Illuminate\Support\Facades\DB;

class ConvertContactMessageToClient
{
    public function handle(ContactMessage $message, array $data): Client
    {
        return DB::transaction(function () use ($message, $data): Client {
            if ($message->client) {
                return $message->client;
            }

            $client = Client::create([
                'name' => $data['name'] ?? $message->name,
                'company' => $data['company'] ?? $message->company,
                'email' => $data['email'] ?? $message->email,
                'phone' => $message->phone,
                'source' => 'Contact form message #'.$message->getKey(),
                'notes' => 'Converted from contact message #'.$message->getKey(),
            ]);

            $scope = trim((string) ($data['scope'] ?? $message->goal ?? $message->message));
            if ($message->project_type || $message->timeline) {
                $scope .= "\n\nScoping: ".implode(' · ', array_filter([$message->project_type, $message->timeline]));
            }
            if (filled($message->message)) {
                $scope .= "\n\nAdditional context: ".$message->message;
            }
            if ($message->budgetLabel()) {
                $scope .= "\n\nBudget indicated: ".$message->budgetLabel();
            }

            Engagement::create([
                'client_id' => $client->id,
                'title' => $data['title'] ?? $message->subject ?: 'Initial engagement',
                'scope' => $scope,
                'pricing_model' => $data['pricing_model'] ?? EngagementPricingModel::Fixed,
                'amount' => $data['amount'] ?? null,
                'currency' => $data['currency'] ?? Currency::EUR,
                'status' => EngagementStatus::Proposal,
            ]);

            $message->update(['client_id' => $client->id, 'status' => ContactMessage::STATUS_PROPOSAL, 'read_at' => $message->read_at ?? now()]);

            return $client;
        });
    }
}
