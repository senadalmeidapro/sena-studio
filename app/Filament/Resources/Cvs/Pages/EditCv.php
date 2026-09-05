<?php

namespace App\Filament\Resources\Cvs\Pages;

use App\Enums\CvStatus;
use App\Filament\Resources\Cvs\CvResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

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
                ->action(fn (): mixed => $this->downloadPdf()),

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

    private function downloadPdf(): Response
    {
        $html = View::make('pdf.cv', ['cv' => $this->record])->render();

        $file = Pdf::loadHTML($html);

        $file->setPaper('a4');
        $file->setOptions([
            'isRemoteEnabled' => false,
            'isHtml5ParserEnabled' => true,
        ]);

        $name = 'CV-'.str_replace(' ', '-', trim((string) ($this->record->version_label ?? $this->record->headline ?? 'sena-studio'))).'.pdf';

        return $file->download($name);
    }
}
