<?php

namespace App\Actions\Blog;

use App\Models\DocumentView;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Prezet\Prezet\Models\Document;

final class DestroyBlogPost
{
    public function handle(int $id): bool
    {
        $document = DB::connection('prezet')->table('documents')->find($id);

        if (! $document) {
            return false;
        }

        try {
            Storage::disk('prezet')->delete("content/{$document->slug}.md");

            DB::connection('prezet')->table('document_tags')->where('document_id', $id)->delete();

            $imageDirectory = "images/{$document->slug}";

            if (Storage::disk('prezet')->exists($imageDirectory)) {
                Storage::disk('prezet')->deleteDirectory($imageDirectory);
            }

            Document::where('id', $id)->delete();

            DocumentView::where('document_id', $id)->delete();

            Artisan::call('prezet:index');

            return true;
        } catch (Exception) {
            return false;
        }
    }
}
