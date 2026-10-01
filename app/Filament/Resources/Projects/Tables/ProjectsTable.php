<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Enums\ProjectStatus;
use App\Enums\ProjectType;
use App\Enums\ProjectVisibility;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('image')
                    ->circular(),

                IconColumn::make('featured')
                    ->label('À la une')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? (string) $state)
                    ->colors([
                        'gray' => 'development',
                        'warning' => 'testing',
                        'success' => 'production',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? (string) $state)
                    ->sortable(),

                TextColumn::make('case_study_completeness')
                    ->label('Étude de cas')
                    ->state(fn ($record): string => $record->caseStudyCompletionCount().'/5')
                    ->badge()
                    ->color(fn ($record): string => $record->hasCompleteCaseStudy() ? 'success' : 'warning'),

                TextColumn::make('started_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('ended_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProjectStatus::options()),

                SelectFilter::make('type')
                    ->options(ProjectType::options()),

                SelectFilter::make('visibility')
                    ->label('Visibility')
                    ->options(ProjectVisibility::options()),

                TernaryFilter::make('featured')
                    ->label('Projets mis en avant'),

                Filter::make('public_projects_with_incomplete_case_study')
                    ->label('Projets publics avec une étude de cas incomplète')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('visibility', ProjectVisibility::Public->value)
                        ->where(function (Builder $query): void {
                            foreach (['role', 'problem', 'architecture', 'technical_decisions', 'result'] as $field) {
                                $query->orWhereNull($field)->orWhere($field, '');
                            }
                        })),

            ])
            ->recordActions([
                Action::make('protectedShareLink')
                    ->label('Signed share link')
                    ->icon('heroicon-o-link')
                    ->visible(fn ($record): bool => $record->visibility === ProjectVisibility::Protected)
                    ->url(function ($record): string {
                        if (blank($record->share_token)) {
                            $record->forceFill(['share_token' => Str::random(64)])->save();
                        }

                        return URL::signedRoute('projects.protected', [
                            'locale' => app()->getLocale(),
                            'project' => $record->slug,
                            'token' => $record->share_token,
                        ]);
                    })
                    ->openUrlInNewTab(),
                Action::make('regenerateShareLink')
                    ->label('Regenerate share link')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn ($record): bool => $record->visibility === ProjectVisibility::Protected)
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->forceFill([
                        'share_token' => Str::random(64),
                    ])->save()),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
