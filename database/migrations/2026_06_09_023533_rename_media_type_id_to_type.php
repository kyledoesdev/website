<?php

use App\Enums\MediaType;
use App\Models\Media;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->renameColumn('type_id', 'type');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->string('type')->change();
        });

        $map = [
            1 => MediaType::MOVIE->value,
            2 => MediaType::TV->value,
            3 => MediaType::ARTIST->value,
            4 => MediaType::TRACK->value,
            5 => MediaType::VIDEO_GAME->value,
        ];

        DB::transaction(function () use ($map): void {
            foreach ($map as $old => $new) {
                Media::withoutGlobalScopes()->where('type', (string) $old)->update(['type' => $new]);
            }
        });
    }

    public function down(): void
    {
        $map = [
            MediaType::MOVIE->value => 1,
            MediaType::TV->value => 2,
            MediaType::ARTIST->value => 3,
            MediaType::TRACK->value => 4,
            MediaType::VIDEO_GAME->value => 5,
        ];

        DB::transaction(function () use ($map): void {
            foreach ($map as $old => $new) {
                Media::withoutGlobalScopes()->where('type', $old)->update(['type' => $new]);
            }
        });

        Schema::table('media', function (Blueprint $table) {
            $table->unsignedBigInteger('type')->change();
        });

        Schema::table('media', function (Blueprint $table) {
            $table->renameColumn('type', 'type_id');
        });
    }
};
