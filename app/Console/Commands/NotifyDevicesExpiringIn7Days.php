<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use Carbon\Carbon;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyDevicesExpiringIn7Days extends Command
{
    protected $signature = 'devices:notify-7days';
    protected $description = 'Notify Telegram when device license remaining days reaches 7';

    public function handle(): int
    {
        $chatId = env('TELEGRAM_CHAT_ID'); // put your -100... id in .env

        $devices = Device::query()
            ->where('status', true)
            ->whereNotNull('licence_end')
            ->whereNull('notified_7_at')
            ->get()
            ->filter(fn($d) => $d->remaining_days === 7 || $d->remaining_days < 7);

        foreach ($devices as $device) {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "⚠️ License Expiring in 7 Days!\n"
                    . "Device: {$device->name}\n"
                    . "Machine No: {$device->machine_number}\n"
                    . "License End: {$device->licence_end->format('Y-m-d')}\n"
                    . "Remaining: {$device->remaining_days} days",
            ]);

            $device->update(['notified_7_at' => now()]);
        }

        $this->info("Notified {$devices->count()} device(s).");
        return self::SUCCESS;
    }
}
