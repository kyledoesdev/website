<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function __invoke(Request $request, string $slug)
    {
        return Storage::disk('s3')
            ->response(Asset::where('slug', $slug)->firstOrFail()->path, null, [
                'Cache-Control' => 'public, max-age=31536000'
            ]);
    }
}
