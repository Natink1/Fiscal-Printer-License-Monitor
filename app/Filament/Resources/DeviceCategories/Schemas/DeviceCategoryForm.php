<?php

namespace App\Filament\Resources\DeviceCategories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class DeviceCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Category Name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }
}
