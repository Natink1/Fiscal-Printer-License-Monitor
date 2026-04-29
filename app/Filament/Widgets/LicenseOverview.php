<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class LicenseOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'License overview';

    protected function getStats(): array
    {
        $today = Carbon::today();
        $inSevenDays = $today->copy()->addDays(7);

        $totalDevices = Device::query()->count();
        $activeDevices = Device::query()->where('status', true)->count();
        $expiringSoon = Device::query()
            ->whereNotNull('licence_end')
            ->whereBetween('licence_end', [$today, $inSevenDays])
            ->count();
        $expired = Device::query()
            ->whereNotNull('licence_end')
            ->whereDate('licence_end', '<', $today)
            ->count();

        return [
            Stat::make('Total devices', number_format($totalDevices))
                ->description(number_format($activeDevices) . ' active')
                ->descriptionIcon(Heroicon::Printer)
                ->color('primary'),

            Stat::make('Expiring in 7 days', number_format($expiringSoon))
                ->description('Need renewal soon')
                ->descriptionIcon(Heroicon::Clock)
                ->color($expiringSoon > 0 ? 'warning' : 'success'),

            Stat::make('Expired licenses', number_format($expired))
                ->description($expired > 0 ? 'Requires attention' : 'All current')
                ->descriptionIcon($expired > 0 ? Heroicon::ExclamationTriangle : Heroicon::CheckCircle)
                ->color($expired > 0 ? 'danger' : 'success'),
        ];
    }
}
