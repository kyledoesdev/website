<?php

use App\Console\Commands\CheckTwitchLiveStatus;
use App\Console\Commands\SendDailyCoffeeMessage;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CheckTwitchLiveStatus::class)->everyFiveMinutes();

Schedule::command(SendDailyCoffeeMessage::class)
    ->dailyAt('10:00')
    ->timezone('America/New_York');
