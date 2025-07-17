<?php

namespace App\Http\Controllers\Prezet;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Prezet\Prezet\Prezet;
use Prezet\Prezet\Models\Document;

class ImageController
{
    public function __invoke(Request $request, string $path): Response
    {
        /* resolve img path from sub dir, trim off 'images/' & pass to prezet */
        $file = Prezet::getImage(ltrim($this->resolveImagePath($path), 'images/'));

        return response($file, 200, [
            'Content-Type' => match (pathinfo($path, PATHINFO_EXTENSION)) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                default => 'image/webp'
            },
            'Content-Length' => strlen($file),
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    private function resolveImagePath(string $filename): ?string
    {
        /* remove any appended size version when looking up path */
        $originalFilename = preg_replace('/-\d+w\./', '.', $filename);
        
        $slugs = Document::pluck('slug')->toArray();
        
        /* loop through the articles' slugs to get dir & file name from prezet disk */
        foreach ($slugs as $slug) {
            $imagePath = "images/{$slug}/{$originalFilename}";
            
            if (Storage::disk('prezet')->exists($imagePath)) {
                return $imagePath;
            }
        }

        /* images should always be in their article's sub dir, so we should really never reach here. */
        return null;
    }
}