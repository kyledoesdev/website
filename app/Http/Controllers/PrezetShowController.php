<?php

namespace App\Http\Controllers;

use App\Libraries\Helpers;
use App\Models\DocumentView;
use BenBjurstrom\Prezet\Http\Controllers\ShowController as BaseShowController;
use BenBjurstrom\Prezet\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrezetShowController extends BaseShowController
{
    public function __invoke(Request $request, $slug): View
    {
        $response = parent::__invoke($request, $slug);

        $document = Document::where('slug', $slug)->first();

        DocumentView::updateOrCreate([
            'document_id' => $document->getKey(),
            'ip_address' => request()->ip(),
        ], [
            'timezone' => Helpers::tz(),
            'last_viewed_at' => now(),
        ]);

        return $response->with([
            'views' => DocumentView::where('document_id', $document->getKey())->count(),
        ]);
    }
}
