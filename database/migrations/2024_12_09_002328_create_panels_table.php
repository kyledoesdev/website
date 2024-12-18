<?php

use App\Models\Panel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name');
            $table->longText('content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Panel::create(['name' => 'Bio', 'content' => null]);
        Panel::create(['name' => 'Work History', 'content' => null]);
        Panel::create(['name' => 'Education', 'content' => null]);
        Panel::create(['name' => 'Projects', 'content' => null]);
    }

    public function down(): void
    {
        Schema::dropIfExists('panels');
    }
};
