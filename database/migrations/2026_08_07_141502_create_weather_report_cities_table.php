<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_report_cities', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('state');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();

            $table->unique(['city', 'state']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_report_cities');
    }
};
