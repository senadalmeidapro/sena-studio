<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\AdminActivityLog;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function afterSave(): void
    {
        AdminActivityLog::record('posts.update', "Article « {$this->record->title} » mis à jour.", $this->record);
    }

    protected function afterCreate(): void
    {
        AdminActivityLog::record('posts.create', "Article « {$this->record->title} » créé.", $this->record);
    }

    protected function afterDelete(): void
    {
        AdminActivityLog::record('posts.delete', "Article « {$this->record->title} » supprimé.");
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Aperçu')
                ->icon('heroicon-m-eye')
                ->color('gray')
                ->visible(fn (): bool => $this->record->isPublished())
                ->url(fn (): string => localized_route('posts.show', $this->record->slug))
                ->openUrlInNewTab(),

            DeleteAction::make(),
        ];
    }
}
