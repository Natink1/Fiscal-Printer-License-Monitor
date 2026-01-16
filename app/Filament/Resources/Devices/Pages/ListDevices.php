<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

// use Carbon\Carbon;
// use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->mutateBeforeValidationUsing(function (array $data): array {

                    // ----- STATUS (optional, keep your status fixer too) -----
                    if (array_key_exists('status', $data)) {
                        $data['status'] = $this->normalizeBool($data['status']); // returns 1/0
                    }
                    return $data;
                }),
            CreateAction::make(),
        ];
    }



    private function normalizeBool($value): int
    {
        $raw = strtoupper(trim((string) $value));
        $raw = ltrim($raw, " ="); // handle "=TRUE()"

        $truthy = ['TRUE()', 'TRUE', 'YES', 'Y', '1', 'ON', 'ACTIVE'];
        $falsy  = ['FALSE()', 'FALSE', 'NO', 'N', '0', 'OFF', 'INACTIVE', ''];

        if (in_array($raw, $truthy, true)) return 1;
        if (in_array($raw, $falsy, true)) return 0;

        return 0;
    }
}
