<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('twitch_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('stream_started_at')->unique();
            $table->timestamp('notified_at');
            $table->timestamps();
        });
    }
};
