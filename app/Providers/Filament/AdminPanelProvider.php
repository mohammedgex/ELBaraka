<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->font('Cairo')
            ->sidebarWidth('15rem')
            ->sidebarCollapsibleOnDesktop()
            ->navigationItems([
                NavigationItem::make('الاشعارات عن بعد')
                    ->url('https://dashboard.onesignal.com/apps/c54d6dfe-27f3-4e1c-9251-ca82ef60eeb1/notifications/new', shouldOpenInNewTab: true)
                    ->group('اعدادات التطبيق')
                    ->sort(1)
                    ->icon('heroicon-o-bell-alert'),
                NavigationItem::make('خدمة العملاء')
                    ->url('https://dashboard.tawk.to/#/dashboard/66b924ae146b7af4a4391d1c', shouldOpenInNewTab: true)
                    ->group('اعدادات التطبيق')
                    ->sort(2)
                    ->icon('heroicon-o-chat-bubble-bottom-center')
            ])
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Sky,
                'info' => Color::Blue,
                'primary' => Color::Orange,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->plugin(\TomatoPHP\FilamentFcm\FilamentFcmPlugin::make())
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
