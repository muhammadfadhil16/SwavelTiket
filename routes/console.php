<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Inspiring;


// Command bawaan Laravel
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

app(Schedule::class)->command('inspire')->hourly();

// Command untuk memperbarui status event
app(Schedule::class)->command('app:update-event-status')->everyMinute();
