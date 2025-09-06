<?php

namespace App\Http\Controllers\Prezet;

use App\Models\DocumentView;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prezet\Prezet\Prezet;

class ShowController
{
    public function __invoke(Request $request, string $slug): View
    {
        $document = Prezet::getDocumentModelFromSlug($slug);

        // Get document content
        $markdown = Prezet::getMarkdown($document->filepath);
        $html = Prezet::parseMarkdown($markdown)->getContent();
        $documentData = Prezet::getDocumentDataFromFile($document->filepath);

        DocumentView::updateOrCreate([
            'document_id' => $document->getKey(),
            'ip_address' => $request->ip(),
        ], [
            'timezone' => timezone(),
            'last_viewed_at' => now(),
        ]);

        return view('prezet.show', [
            'document' => $documentData,
            'linkedData' => json_encode(Prezet::getLinkedData($documentData), JSON_UNESCAPED_SLASHES),
            'headings' => Prezet::getHeadings($html),
            'body' => $html,
            'nav' => Prezet::getSummary(),
            'views' => DocumentView::where('document_id', $document->getKey())->count(),
        ]);
    }
}
