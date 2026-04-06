<?php

namespace App\Actions\Blog;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Prezet\Prezet\Models\Document;

final class StoreBlogPost
{
    /**
     * @param  array<int, UploadedFile>  $images
     */
    public function handle(UploadedFile $file, array $images = []): void
    {
        $file->storeAs(
            path: '/content',
            name: $file->getClientOriginalName(),
            options: ['disk' => 'prezet']
        );

        Artisan::call('prezet:index');

        $document = Document::query()->latest()->first();

        if ($document && $images) {
            foreach ($images as $image) {
                $image->storeAs(
                    path: "images/{$document->slug}",
                    name: $image->getClientOriginalName(),
                    options: ['disk' => 'prezet']
                );
            }

            Artisan::call('prezet:index');
        }
    }
}
