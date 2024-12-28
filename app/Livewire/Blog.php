<?php

namespace App\Livewire;

use App\Livewire\Traits\TableHelpers;
use App\Models\DocumentView;
use BenBjurstrom\Prezet\Models\Document;
use Flux\Flux;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Blog extends Component
{
    use TableHelpers;
    use WithFileUploads;

    #[Validate('required|file|mimes:md')]
    public $file;

    public function render()
    {
        return view('livewire.blog');
    }

    public function store()
    {
        $this->validate();

        $this->file->storeAs(
            path: '/content',
            name: $this->file->getClientOriginalName(),
            options: ['disk' => 'prezet']
        );

        Artisan::call('prezet:index');

        $this->file = null;

        Flux::toast(variant: 'success', text: 'Blog Post Uploaded!', duration: 3000);
    }

    #[Computed]
    public function posts()
    {
        $documents = DB::connection('prezet')->table('documents')->get();

        $views = DocumentView::select('document_id', DB::raw('COUNT(*) as views'))
            ->groupBy('document_id')
            ->pluck('views', 'document_id');

        foreach ($documents as $document) {
            $document->views = $views->get($document->id, 0);
        }

        if ($this->sortBy) {
            $documents = collect($documents)->sortBy(function ($document) {
                return json_decode($document->frontmatter)->{$this->sortBy} ?? $document->{$this->sortBy};
            });
    
            if ($this->sortDirection === 'desc') {
                $documents = $documents->reverse();
            }
        }

        return $documents;
    }
}
