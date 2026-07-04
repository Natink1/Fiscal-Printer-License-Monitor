<?php

namespace App\Filament\Resources\Devices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DevicesTable
{
    public static function configure(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('machine_number')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Device Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('licence_end')
                    ->date()
                    ->sortable(),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('remaining_days')
                    ->label('Remaining Days')
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => $state === null ? 'gray' : ($state < 0 ? 'danger' : ($state <= 7 ? 'warning' : 'success')))
                    ->formatStateUsing(fn($state) => $state === null ? 'N/A' : ($state < 0 ? "Expired (" . abs($state) . "d)" : "{$state} days")),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('licence_end', 'asc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
