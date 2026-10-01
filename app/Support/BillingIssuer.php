<?php

namespace App\Support;

class BillingIssuer
{
    private const REQUIRED = ['legal_name', 'address', 'tax_id', 'bank_details', 'payment_details'];

    public function details(): array
    {
        $configured = (array) config('services.billing.issuer', []);

        return collect(self::REQUIRED)->mapWithKeys(fn (string $key): array => [
            $key => filled($configured[$key] ?? null) ? $configured[$key] : 'TODO: FIX ME — configure billing issuer '.str_replace('_', ' ', $key),
        ])->all();
    }

    public function missing(): array
    {
        $configured = (array) config('services.billing.issuer', []);

        return collect(self::REQUIRED)
            ->filter(fn (string $key): bool => blank($configured[$key] ?? null))
            ->values()
            ->all();
    }
}
