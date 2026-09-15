<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Concerns\HandlesCloudinaryImages;
use App\Filament\Resources\Posts\PostResource;
use App\Models\AdminActivityLog;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\URL;

class EditPost extends EditRecord
{
    use HandlesCloudinaryImages;

    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $this->cloudinaryFormImage($data, 'cover_image');
    }

    protected function afterSave(): void
    {
        $this->finalizeCloudinaryCleanup();

        AdminActivityLog::record('posts.update', "Article « {$this->record->title} » mis à jour.", $this->record);
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
                ->url(fn (): string => $this->record->isPublished()
                    ? localized_route('posts.show', $this->record->slug)
                    : URL::temporarySignedRoute('posts.preview', now()->addMinutes(30), [
                        'locale' => app()->getLocale(),
                        'post' => $this->record->slug,
                    ]))
                ->openUrlInNewTab(),

            DeleteAction::make(),
        ];
    }
}
