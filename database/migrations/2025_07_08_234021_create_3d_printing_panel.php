<?php

use App\Models\Panel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Panel::create([
            'type' => 'fun',
            'name' => '3d_printing',
            'display_name' => '3D Printing',
            'content' => null,
        ]);
    }
};
