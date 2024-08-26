<?php

namespace App\Filament\Resources\RepresentativePaymentRequestResource\Pages;

use App\Filament\Resources\RepresentativePaymentRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepresentativePaymentRequests extends ListRecords
{
    protected static string $resource = RepresentativePaymentRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
