<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('machine_number')
                    ->required(),
                DatePicker::make('licence_end'),
                Toggle::make('status')->default(true)
                ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle'),
                TextInput::make('remaining_days'),
            ]);
    }
}
