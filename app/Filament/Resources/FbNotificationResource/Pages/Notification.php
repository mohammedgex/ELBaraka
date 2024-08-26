<?php

namespace App\Filament\Resources\FbNotificationResource\Pages;

use App\Filament\Resources\FbNotificationResource;
use Filament\Resources\Pages\Page;

class Notification extends Page
{
    protected static string $resource = FbNotificationResource::class;

    protected static string $view = 'filament.resources.fb-notification-resource.pages.notification';

    protected static ?string $navigationIcon = 'heroicon-o-document';
 

    public function mount(): void
    {
        $this->notify('success', 'This is a custom notification on page load!');
    }
}
