<?php

namespace App\Http\Controllers;

use App\Models\DocumentView;
use BenBjurstrom\Prezet\Http\Controllers\IndexController as BaseIndexController;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrezetIndexController extends BaseIndexController
{
    public function __invoke(Request $request): View
    {
        $response = parent::__invoke($request);

        $views = DocumentView::all();

        /* a big fancy way to associate document views with front-matter articles */
        collect($response->paginator->items())->each(function ($document) use ($response, $views) {
            collect($response->articles)->each(function ($article) use ($document, $views) {
                /* set the "article (front matter)" views based off of the relation between a "document" and its views */
                $article->views = $views->where('document_id', $document->id)->count();
            });
        });

        return $response;
    }
}
