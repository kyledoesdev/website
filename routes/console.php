<?php

use App\Console\Commands\CheckTwitchLiveStatus;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CheckTwitchLiveStatus::class)->everyFiveMinutes();
