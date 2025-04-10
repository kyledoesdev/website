<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id');
            $table->string('name');
            $table->string('slug');
            $table->string('path');
            $table->string('mime_type');
            $table->json('data')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('resumes');
        Schema::dropIfExists('photos');
    }
};
