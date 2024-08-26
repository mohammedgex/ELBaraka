<?php

namespace App\Filament\Resources\BusResource\Pages;

use App\Filament\Resources\BusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListBuses extends ListRecords
{
    protected static string $resource = BusResource::class;

    /**
     * Get the query used to retrieve the records.
     *
     * @return Builder
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->withCount('busRoutes');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
