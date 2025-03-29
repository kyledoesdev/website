<?php

use App\Models\ConnectionType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connection_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        ConnectionType::create(['name' => 'Spotify']);
        ConnectionType::create(['name' => 'Twitch']);

        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('external_id');
            $table->string('type_id');
            $table->string('token');
            $table->string('refresh_token')->nullable();
            $table->timestamps();
        });
    }
};
