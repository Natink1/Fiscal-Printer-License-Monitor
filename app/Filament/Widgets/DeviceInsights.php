<?php

namespace App\Filament\Widgets;

use App\Models\Device;
use App\Models\DeviceCategory;
use Filament\Widgets\Widget;

class DeviceInsights extends Widget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.device-insights';

    protected function getViewData(): array
    {
        $total = Device::query()->count();
        $active = Device::query()->where('status', true)->count();
        $categories = DeviceCategory::query()
            ->withCount('devices')
            ->orderByDesc('devices_count')
            ->orderBy('name')
            ->get()
            ->map(fn (DeviceCategory $category): array => [
                'name' => $category->name,
                'count' => $category->devices_count,
            ]);

        $uncategorized = Device::query()->whereNull('device_category_id')->count();

        if ($uncategorized > 0) {
            $categories->push(['name' => 'Uncategorized', 'count' => $uncategorized]);
        }

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $total - $active,
            'activePercentage' => $total > 0 ? round($active / $total * 100) : 0,
            'categories' => $categories,
            'maximum' => max(1, $categories->max('count') ?? 0),
        ];
    }
}
