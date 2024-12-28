<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id');
            $table->string('ip_address', 45);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['document_id', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_views');
    }
};
