<?php

namespace App\Modules\Inquiries\Filament\Resources\Inquiries\Pages;

use App\Modules\Inquiries\Enums\InquiryStatus;
use App\Modules\Inquiries\Filament\Resources\Inquiries\InquiryResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewInquiry extends ViewRecord
{
    protected static string $resource = InquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('markRead')
                ->label('Marquer comme consultée')
                ->icon(Heroicon::OutlinedEnvelopeOpen)
                ->visible(fn (): bool => $this->record->read_at === null)
                ->action(fn () => $this->record->markRead()),
            Action::make('changeStatus')
                ->label('Changer le statut')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->schema([
                    Select::make('status')
                        ->label('Nouveau statut')
                        ->options(InquiryResource::statusOptions())
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->moveTo(InquiryStatus::from($data['status']));
                    $this->refreshFormData(['status', 'read_at', 'handled_at', 'archived_at']);
                }),
            Action::make('addNote')
                ->label('Ajouter une note')
                ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                ->schema([Textarea::make('note')->label('Note interne')->required()->rows(5)])
                ->action(function (array $data): void {
                    $this->record->update([
                        'internal_notes' => trim(($this->record->internal_notes ? $this->record->internal_notes."\n\n" : '').$data['note']),
                    ]);
                    $this->refreshFormData(['internal_notes']);
                    Notification::make()->title('Note ajoutée')->success()->send();
                }),
        ];
    }
}
