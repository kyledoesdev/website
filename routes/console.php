<?php

use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;

Schedule::command(ScheduleCheckHeartbeatCommand::class)->everyMinute();
Schedule::command('model:prune', [
    '--model' => [
        \Spatie\Health\Models\HealthCheckResultHistoryItem::class,
    ],
])->daily();
