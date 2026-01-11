<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
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
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                TextInput::make('remaining_days'),
            ]);
    }
}
