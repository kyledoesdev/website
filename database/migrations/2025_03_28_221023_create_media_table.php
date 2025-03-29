<?php

use App\Models\MediaType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        MediaType::create(['name' => 'Movies']);
        MediaType::create(['name' => 'TV Shows']);

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id');
            $table->string('media_id');
            $table->string('name');
            $table->string('cover');
            $table->boolean('is_favorite');
            $table->boolean('in_backlog');
            $table->boolean('is_completed');
            $table->timestamps();
        });
    }
};
