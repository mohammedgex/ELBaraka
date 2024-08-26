<?php

namespace App\Filament\Resources\CompanyHqPaymentRequestResource\Pages;

use App\Filament\Resources\CompanyHqPaymentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyHqPaymentRequest extends EditRecord
{
    protected static string $resource = CompanyHqPaymentRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
