<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DeviceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('name'),
                TextEntry::make('machine_number'),
                TextEntry::make('licence_end')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('remaining_days')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
