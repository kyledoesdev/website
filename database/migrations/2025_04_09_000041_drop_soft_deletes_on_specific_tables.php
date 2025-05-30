<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* there was really no need for these */
    public function up(): void
    {
        Schema::table('document_views', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('technologies', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('photos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('panels', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
