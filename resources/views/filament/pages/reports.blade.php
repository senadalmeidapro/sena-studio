<x-filament-panels::page>
    <div class="space-y-6">
        <div class="max-w-xs">
            <label for="report-range" class="fi-fo-field-wrp-label">Date range</label>
            <select id="report-range" wire:model.live="range" class="fi-select-input mt-1 w-full rounded-lg border-gray-300">
                @foreach ($ranges as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-filament::section heading="Lead to client conversion">
                <p class="text-2xl font-semibold">{{ $report['lead_conversion']['rate'] }}%</p>
                <p class="text-sm text-gray-500">{{ $report['lead_conversion']['converted'] }} of {{ $report['lead_conversion']['total'] }} leads</p>
            </x-filament::section>
            <x-filament::section heading="Average days to first engagement">
                <p class="text-2xl font-semibold">{{ $report['average_days_to_first_engagement'] === null ? '—' : $report['average_days_to_first_engagement'] }}</p>
            </x-filament::section>
            <x-filament::section heading="Open receivables">
                @foreach ($report['open_receivables'] as $currency => $amount)
                    <p>{{ app(\App\Support\MoneyFormatter::class)->format($amount, $currency) }}</p>
                @endforeach
            </x-filament::section>
        </div>

        <x-filament::section heading="Paid revenue by month">
            @if ($report['revenue_by_month'] === [])
                <p class="text-sm text-gray-500">No paid invoices in this date range.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead><tr class="text-left"><th class="p-2">Month</th><th class="p-2">Amount</th></tr></thead>
                        <tbody>
                            @foreach ($report['revenue_by_month'] as $row)
                                <tr><td class="p-2">{{ $row['month'] }}</td><td class="p-2">{{ app(\App\Support\MoneyFormatter::class)->format($row['amount'], $row['currency']) }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>

        <x-filament::section heading="Paid revenue by project type">
            @if ($report['revenue_by_project_type'] === [])
                <p class="text-sm text-gray-500">No project revenue in this date range.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead><tr class="text-left"><th class="p-2">Project type</th><th class="p-2">Amount</th></tr></thead>
                        <tbody>
                            @foreach ($report['revenue_by_project_type'] as $row)
                                <tr><td class="p-2">{{ $row['project_type'] }}</td><td class="p-2">{{ app(\App\Support\MoneyFormatter::class)->format($row['amount'], $row['currency']) }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
