<?php

namespace App\Livewire;

use App\Livewire\Traits\TableHelpers;
use App\Models\DocumentView;
use BenBjurstrom\Prezet\Models\Document;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class BlogViews extends Component
{
    use TableHelpers;
    use WithPagination;

    public Document $post;

    public function render()
    {
        return view('livewire.blog-views');
    }

    #[Computed]
    public function views()
    {
        return DocumentView::query()
            ->where('document_id', $this->post->getKey())
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }
}
