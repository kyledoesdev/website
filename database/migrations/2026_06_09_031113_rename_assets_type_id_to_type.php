<?php

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->renameColumn('type_id', 'type');
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->string('type')->change();
        });

        $map = [
            1 => AssetType::PHOTO->value,
            2 => AssetType::RESUME->value,
            3 => AssetType::THREE_D_PRINTS->value,
        ];

        DB::transaction(function () use ($map): void {
            foreach ($map as $old => $new) {
                Asset::withoutGlobalScopes()->where('type', (string) $old)->update(['type' => $new]);
            }
        });
    }

    public function down(): void
    {
        $map = [
            AssetType::PHOTO->value => 1,
            AssetType::RESUME->value => 2,
            AssetType::THREE_D_PRINTS->value => 3,
        ];

        DB::transaction(function () use ($map): void {
            foreach ($map as $old => $new) {
                Asset::withoutGlobalScopes()->where('type', $old)->update(['type' => $new]);
            }
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->integer('type')->change();
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->renameColumn('type', 'type_id');
        });
    }
};
