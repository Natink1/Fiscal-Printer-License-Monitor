<?php

namespace App\Filament\Resources\DeviceCategories;

use App\Filament\Resources\DeviceCategories\Pages\CreateDeviceCategory;
use App\Filament\Resources\DeviceCategories\Pages\EditDeviceCategory;
use App\Filament\Resources\DeviceCategories\Pages\ListDeviceCategories;
use App\Filament\Resources\DeviceCategories\Pages\ViewDeviceCategory;
use App\Filament\Resources\DeviceCategories\Schemas\DeviceCategoryForm;
use App\Filament\Resources\DeviceCategories\Schemas\DeviceCategoryInfolist;
use App\Filament\Resources\DeviceCategories\Tables\DeviceCategoriesTable;
use App\Models\DeviceCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceCategoryResource extends Resource
{
    protected static ?string $model = DeviceCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderMinus;

    protected static ?string $recordTitleAttribute = 'Device Category';

    public static function form(Schema $schema): Schema
    {
        return DeviceCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DeviceCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeviceCategories::route('/'),
            'create' => CreateDeviceCategory::route('/create'),
            'view' => ViewDeviceCategory::route('/{record}'),
            'edit' => EditDeviceCategory::route('/{record}/edit'),
        ];
    }
}
