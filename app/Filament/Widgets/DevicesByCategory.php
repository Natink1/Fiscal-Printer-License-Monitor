<?php

// namespace App\Filament\Widgets;

// use App\Models\Device;
// use Filament\Widgets\ChartWidget;

// class DevicesByCategory extends ChartWidget
// {
//     protected static ?int $sort = 2;

//     protected ?string $heading = 'Devices by category';

//     protected string $color = 'info';

//     protected int | string | array $columnSpan = 'full';

//     protected function getData(): array
//     {
//         $categories = Device::query()
//             ->with('category:id,name')
//             ->get(['id', 'device_category_id'])
//             ->groupBy(fn (Device $device): string => $device->category?->name ?? 'Uncategorized')
//             ->map(fn ($devices): int => $devices->count())
//             ->sortDesc();

//         return [
//             'datasets' => [
//                 [
//                     'label' => 'Devices',
//                     'data' => $categories->values()->all(),
//                     'backgroundColor' => [
//                         '#f59e0b',
//                         '#2563eb',
//                         '#10b981',
//                         '#ef4444',
//                         '#8b5cf6',
//                         '#14b8a6',
//                         '#f97316',
//                         '#64748b',
//                     ],
//                 ],
//             ],
//             'labels' => $categories->keys()->all(),
//         ];
//     }

//     protected function getType(): string
//     {
//         return 'doughnut';
//     }
// }
