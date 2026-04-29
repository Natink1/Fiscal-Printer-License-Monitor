<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Devices\DeviceResource;
use App\Models\Device;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ExpiringLicenses extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $today = Carbon::today();

        return $table
            ->heading('Licenses needing attention')
            ->query(
                Device::query()
                    ->with('category')
                    ->whereNotNull('licence_end')
                    ->whereDate('licence_end', '<=', $today->copy()->addDays(30))
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('machine_number')
                    ->label('Machine number')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->placeholder('Uncategorized')
                    ->sortable(),
                TextColumn::make('licence_end')
                    ->label('License ends')
                    ->date()
                    ->sortable(),
                TextColumn::make('remaining_days')
                    ->label('Remaining')
                    ->badge()
                    ->color(fn (?int $state): string => match (true) {
                        $state === null => 'gray',
                        $state < 0 => 'danger',
                        $state <= 7 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn (?int $state): string => match (true) {
                        $state === null => 'N/A',
                        $state < 0 => 'Expired ' . abs($state) . 'd ago',
                        $state === 0 => 'Expires today',
                        default => $state . ' days',
                    }),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
            ])
            ->defaultSort('licence_end')
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->limit(10))
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Device $record): string => DeviceResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
