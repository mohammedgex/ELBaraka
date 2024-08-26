<?php

namespace App\Filament\Resources\CompanyHqPaymentRequestResource\Pages;

use App\Filament\Resources\CompanyHqPaymentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyHqPaymentRequests extends ListRecords
{
    protected static string $resource = CompanyHqPaymentRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
