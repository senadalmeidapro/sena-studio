<?php

namespace App\Support;

use App\Models\Invoice;

class InvoiceNumberGenerator
{
    public function next(?int $year = null): string
    {
        $year ??= now()->year;
        $prefix = $year.'-';
        $lastSequence = Invoice::query()
            ->where('number', 'like', $prefix.'%')
            ->pluck('number')
            ->map(fn (string $number): int => preg_match('/^'.preg_quote($prefix, '/').'([0-9]{3,})$/', $number, $matches) ? (int) $matches[1] : 0)
            ->max() ?? 0;

        return $prefix.str_pad((string) ($lastSequence + 1), 3, '0', STR_PAD_LEFT);
    }
}
