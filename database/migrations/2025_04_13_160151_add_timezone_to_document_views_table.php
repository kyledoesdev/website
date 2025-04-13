<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_views', function (Blueprint $table) {
            $table->string('timezone')->after('ip_address')->nullable();
            $table->timestamp('last_viewed_at')->after('updated_at')->nullable();
        });
    }
};
