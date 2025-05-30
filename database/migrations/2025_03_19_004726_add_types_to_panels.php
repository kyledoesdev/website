<?php

use App\Models\Panel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('panels', function (Blueprint $table) {
            $table->string('type')->after('id')->default('career');
        });

        Panel::all()->each(fn ($panel) => $panel->update(['type' => 'career']));

        Panel::create(['name' => 'video_games', 'display_name' => 'Video Games', 'type' => 'fun', 'content' => null]);
        Panel::create(['name' => 'board_games', 'display_name' => 'Board Games', 'type' => 'fun', 'content' => null]);
        Panel::create(['name' => 'music',       'display_name' => 'Music',       'type' => 'fun', 'content' => null]);
        Panel::create(['name' => 'movies',      'display_name' => 'Movies',      'type' => 'fun', 'content' => null]);
        Panel::create(['name' => 'tv',          'display_name' => 'TV Shows',    'type' => 'fun', 'content' => null]);
    }
};
