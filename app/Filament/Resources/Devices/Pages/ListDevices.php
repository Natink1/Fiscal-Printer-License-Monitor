<?php

namespace App\Filament\Resources\Devices\Pages;

use App\Filament\Resources\Devices\DeviceResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;


class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->mutateBeforeValidationUsing(function (array $data): array {

                    // ----- DATE (licence_end) -----
                    if (array_key_exists('licence_end', $data)) {
                       $data['licence_end'] = $this->normalizeDate($data['licence_end']);
                    }

                    // ----- STATUS (optional, keep your status fixer too) -----
                    if (array_key_exists('status', $data)) {
                        $data['status'] = $this->normalizeBool($data['status']); // returns 1/0
                    }

                    return $data;
                }),
        ];
    }

    /**
     * Accepts Excel serial, and many string formats.
     * Returns 'Y-m-d' or null.
     */
    private function normalizeDate($value): ?string
    {
        if ($value === null) return null;

        $v = trim((string) $value);
        if ($v === '') return null;

        // 1) Excel serial number (date or datetime)
        // Excel date serials are typically > 20000 for modern years.
        // If it's small like 0.53, that's just a time fraction (ignore or null).
        if (is_numeric($v)) {
            $num = (float) $v;

            // If it's just time fraction (0 < num < 1), DO NOT convert to date
            if ($num > 0 && $num < 1) {
                return null; // or keep as today? but null is safest
            }

            // Convert Excel serial to DateTime
            $dt = ExcelDate::excelToDateTimeObject($num);

            // Guard: never allow 1970-01-01 unless Excel value truly means that
            $carbon = Carbon::instance($dt);
            if ($carbon->year < 1980) {
                return null;
            }

            return $carbon->format('Y-m-d');
        }

        // 2) String formats (explicit)
        foreach (
            [
                'Y-m-d',
                'Y/m/d',
                'm-d-Y',
                'd-m-Y',
                'm/d/Y',
                'd/m/Y',
                'm-d-y',
                'd-m-y',
                'm/d/y',
                'd/m/y',
            ] as $format
        ) {
            try {
                return Carbon::createFromFormat($format, $v)->format('Y-m-d');
            } catch (\Throwable $e) {
            }
        }

        // 3) Last resort parse
        try {
            $c = Carbon::parse($v);
            if ($c->year < 1980) return null;
            return $c->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
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
