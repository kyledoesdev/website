<?php

namespace App\Http\Controllers\Prezet;

use App\Models\DocumentView;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Prezet;

class IndexController
{
    public function __invoke(Request $request): View
    {
        $documents = $this->getFilteredDocuments($request);
        $articlesWithViews = $this->attachViewCounts($documents);

        return view('prezet.index', [
            'nav' => Prezet::getSummary(),
            'articles' => $articlesWithViews,
            'paginator' => $documents,
            'currentTag' => $request->query('tag'),
            'currentCategory' => $request->query('category'),
        ]);
    }

    private function getFilteredDocuments(Request $request)
    {
        $query = Document::where('draft', false);

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($tag = $request->input('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $tag));
        }

        return $query->orderBy('created_at', 'desc')->paginate(4);
    }

    private function attachViewCounts($documents)
    {
        $articlesData = $documents->map(fn (Document $doc) => DocumentData::fromModel($doc));

        // Get all view counts in one query, indexed by document_id
        $viewCounts = DocumentView::whereIn('document_id', $documents->pluck('id'))
            ->selectRaw('document_id, COUNT(*) as count')
            ->groupBy('document_id')
            ->pluck('count', 'document_id');

        // Attach view counts to articles
        $articlesData->each(function ($article) use ($viewCounts) {
            $article->views = $viewCounts->get($article->id, 0);
        });

        return $articlesData;
    }
}
