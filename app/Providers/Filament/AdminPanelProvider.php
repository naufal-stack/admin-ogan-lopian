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
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Route;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin; // Import plugin
use App\Filament\Admin\Widgets\ManagementOverview;
use App\Filament\Admin\Widgets\ManagementChart;
use App\Filament\Resources\AdminResource\Widgets\ManagementVisitorChart;
use App\Filament\Resources\AdminResource\Widgets\ManagementBookingChart;
use App\Filament\Resources\AdminResource\Widgets\ManagementLaporChart;


class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()

            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Admin\Widgets\EarningsOverview::class,
                ManagementOverview::class,
                ManagementChart::class,
                ManagementVisitorChart::class,
                ManagementBookingChart::class,
                ManagementLaporChart::class
            ])
            ->navigationItems([
    NavigationItem::make('Logout')
        ->label('Logout')
        ->icon('heroicon-o-arrow-right-on-rectangle')
        ->url('/logout') // atau route('logout') jika route terdaftar
        ->group('Akun') // opsional, bisa dikosongkan
        ->sort(999),
])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentShieldPlugin::make()); // Tambahkan plugin ini

    }

}
