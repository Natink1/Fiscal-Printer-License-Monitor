<?php

namespace App\Providers\Filament;

use App\Filament\Resources\Companies\CompanyResource;
use App\Filament\Resources\DeviceCategories\DeviceCategoryResource;
use App\Filament\Resources\Devices\DeviceResource;
use App\Models\DeviceCategory;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;


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
                'primary' => Color::Amber,
            ])

            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $categoryItems = DeviceCategory::query()
                    ->orderBy('name')
                    ->get()
                    ->map(
                        fn(DeviceCategory $category): NavigationItem => NavigationItem::make('device-category-' . $category->id)
                            ->label($category->name)
                            ->url(fn(): string => DeviceResource::getUrl('index', [
                                'category_id' => $category->id,
                            ]))
                            ->isActiveWhen(
                                fn(): bool =>
                                request()->routeIs('filament.admin.resources.devices.*')
                                    && (string) request()->query('category_id') === (string) $category->id
                            )
                    )
                    ->all();

                return $builder->items([
                    NavigationItem::make('dashboard')
                        ->label('Dashboard')
                        ->icon('heroicon-o-home')
                        ->url(fn(): string => Dashboard::getUrl())
                        ->isActiveWhen(
                            fn(): bool =>
                            request()->routeIs('filament.admin.pages.dashboard')
                        ),

                    NavigationItem::make('manage-device-categories')
                        ->label('Manage Categories')
                        ->icon('heroicon-o-tag')
                        ->url(fn(): string => DeviceCategoryResource::getUrl('index'))
                        ->isActiveWhen(
                            fn(): bool =>
                            request()->routeIs('filament.admin.resources.device-categories.*')
                        ),

                    NavigationItem::make('company')
                        ->label('Companies')
                        ->icon('heroicon-o-building-office')
                        ->url(fn(): string => CompanyResource::getUrl('index'))
                        ->isActiveWhen(
                            fn(): bool =>
                            request()->routeIs('filament.admin.resources.companies.*')
                        ),
                    NavigationItem::make('devices-menu')
                        ->label('Devices')
                        ->icon('heroicon-o-computer-desktop')
                        ->url(fn(): string => DeviceResource::getUrl('index'))
                        ->isActiveWhen(
                            fn(): bool =>
                            request()->routeIs('filament.admin.resources.devices.*')
                        )
                        ->childItems([
                            NavigationItem::make('all-devices')
                                ->label('All Devices')
                                ->url(fn(): string => DeviceResource::getUrl('index'))
                                ->isActiveWhen(
                                    fn(): bool =>
                                    request()->routeIs('filament.admin.resources.devices.*')
                                        && ! request()->has('category_id')
                                ),

                            ...$categoryItems,
                        ])

                ]);
            })

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])

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
