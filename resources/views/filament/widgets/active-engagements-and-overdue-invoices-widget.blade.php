<x-filament-widgets::widget>
    <x-filament::section heading="Engagements et factures">
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ \App\Filament\Resources\Engagements\EngagementResource::getUrl('index') }}" class="rounded-xl bg-gray-50 p-4 dark:bg-gray-900">
                <div class="text-sm text-gray-500">Engagements actifs</div>
                <div class="mt-1 text-2xl font-semibold">{{ $activeEngagements }}</div>
            </a>
            <a href="{{ \App\Filament\Resources\Invoices\InvoiceResource::getUrl('index') }}" class="rounded-xl bg-gray-50 p-4 dark:bg-gray-900">
                <div class="text-sm text-gray-500">Factures en retard</div>
                <div class="mt-1 text-2xl font-semibold">{{ $overdueInvoices }}</div>
            </a>
        </div>
    </x-filament-widgets::widget>
</x-filament-widgets::widget>
