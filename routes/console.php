<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// app()->booted(function () {
//     $schedule = app(Schedule::class);

// });

Schedule::command('devices:notify-7days')->everyMinute();
