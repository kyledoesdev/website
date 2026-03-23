<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('steam_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('steam_game_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('playtime_forever_minutes');
            $table->unsignedInteger('playtime_2weeks_minutes');
            $table->unsignedInteger('achievement_unlocked');
            $table->decimal('achievement_completion_pct', 5, 1);
            $table->decimal('priority_score', 8, 2);
            $table->timestamp('fetched_at');
            $table->timestamps();

            $table->index(['steam_game_id', 'fetched_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam_snapshots');
    }
};
