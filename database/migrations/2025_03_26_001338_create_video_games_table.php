<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_games', function (Blueprint $table) {
            $table->id();
            $table->string('twitch_id');
            $table->string('name');
            $table->integer('rank')->nullable();
            $table->string('cover');
            $table->boolean('is_favorite')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('in_backlog')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
