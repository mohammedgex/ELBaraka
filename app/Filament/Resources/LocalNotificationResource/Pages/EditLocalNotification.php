<?php

namespace App\Filament\Resources\LocalNotificationResource\Pages;

use App\Filament\Resources\LocalNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocalNotification extends EditRecord
{
    protected static string $resource = LocalNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
