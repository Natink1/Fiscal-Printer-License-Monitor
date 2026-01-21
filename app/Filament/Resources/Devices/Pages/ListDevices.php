<?php

namespace App\Filament\Resources\Devices\Pages;

use Illuminate\Support\Carbon;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;

use App\Filament\Resources\Devices\DeviceResource;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
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

                    if (!empty($data['date'])) {
                        $dateString = trim((string) $data['date']);

                        $formats = [
                            'n/j/Y',  // 12/25/2023 (US format)
                            'j/n/Y',  // 25/12/2023 (EU format)
                            'Y-m-d',  // 2023-12-25 (ISO format)
                            'd/m/Y',  // 25/12/2023
                            'm/d/Y',  // 12/25/2023
                        ];

                        $date = null;
                        foreach ($formats as $format) {
                            $parsedDate = Carbon::createFromFormat($format, $dateString);
                            if ($parsedDate !== false) {
                                $date = $parsedDate;
                                break;
                            }
                        }

                        // If no f// Try multiple common formatsormat matched, try Carbon's intelligent parser
                        if (!$date) {
                            try {
                                $date = Carbon::parse($dateString);
                            } catch (\Exception $e) {
                                // If parsing fails, keep original and let validation handle it
                                Notification::make()
                                    ->title('Date Parse Error')
                                    ->body("Could not parse date: {$dateString}")
                                    ->danger()
                                    ->send();
                            }
                        }

                        // Assign the parsed date if successful
                        if ($date) {
                            $data['date'] = $date->format('Y-m-d'); // Format for database
                        }
                    }

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
