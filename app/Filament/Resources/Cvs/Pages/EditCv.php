<?php

namespace App\Filament\Resources\Cvs\Pages;

use App\Enums\CvStatus;
use App\Filament\Resources\Cvs\CvResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\RedirectResponse;

class EditCv extends EditRecord
{
    protected static string $resource = CvResource::class;

    protected function afterSave(): void
    {
        if ($this->record->is_primary) {
            $this->record->makePrimary();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Aperçu')
                ->icon('heroicon-m-eye')
                ->color('gray')
                ->url(fn (): string => route('cv.show', $this->record->slug))
                ->openUrlInNewTab(),

            Action::make('downloadPdf')
                ->label('Télécharger le PDF')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Télécharger le PDF')
                ->modalDescription('Génère une version PDF (modèle « Classique ») de cette version du CV.')
                ->action(fn (): RedirectResponse => redirect()->route('admin.cvs.pdf', $this->record)),

            Action::make('duplicate')
                ->label('Dupliquer')
                ->icon('heroicon-m-document-duplicate')
                ->action(function (): void {
                    $copy = $this->record->replicate(['slug']);
                    $copy->version_label = ($this->record->version_label ?? 'Copie').' — Copie';
                    $copy->slug = null;
                    $copy->status = CvStatus::Draft;
                    $copy->is_primary = false;
                    $copy->save();

                    $this->redirect(static::getResource()::getUrl('edit', ['record' => $copy]));
                }),
        ];
    }
}
