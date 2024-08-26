<?php

namespace App\Filament\Resources\RepresentativePaymentRequestResource\Pages;

use App\Filament\Resources\RepresentativePaymentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepresentativePaymentRequest extends EditRecord
{
    protected static string $resource = RepresentativePaymentRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
