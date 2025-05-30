<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        $file = Storage::disk('s3')->get($photo->path);

        return response($file, 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => "inline; filename='{$photo->name}'.pdf",
        ]);
    }
}
