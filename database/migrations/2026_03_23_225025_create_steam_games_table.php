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
        Schema::create('steam_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('app_id')->unique();
            $table->string('name');
            $table->string('img_icon_url')->nullable();
            $table->unsignedInteger('playtime_forever_minutes')->default(0);
            $table->unsignedInteger('playtime_2weeks_minutes')->default(0);
            $table->date('last_played_at')->nullable();
            $table->unsignedInteger('achievement_total')->default(0);
            $table->unsignedInteger('achievement_unlocked')->default(0);
            $table->decimal('achievement_completion_pct', 5, 1)->default(0);
            $table->json('achievement_details')->nullable();
            $table->decimal('priority_score', 8, 2)->default(0);
            $table->string('priority_tier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam_games');
    }
};
