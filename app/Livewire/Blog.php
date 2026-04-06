<?php

namespace App\Livewire;

use App\Actions\Blog\DestroyBlogPost;
use App\Actions\Blog\StoreBlogPost;
use App\Livewire\Traits\TableHelpers;
use App\Models\DocumentView;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Prezet\Prezet\Models\Document;

class Blog extends Component
{
    use TableHelpers;
    use WithFileUploads;
    use WithPagination;

    #[Validate('required|file|mimes:md')]
    public $file;

    #[Validate(['images' => 'nullable|array', 'images.*' => 'image|max:4096'])]
    public $images = [];

    public function render()
    {
        return view('livewire.blog');
    }

    public function store()
    {
        $this->validate();

        (new StoreBlogPost)->handle($this->file, $this->images);

        $this->file = null;
        $this->images = [];

        Flux::toast(variant: 'success', text: 'Blog Post Uploaded!', duration: 3000);
    }

    public function destroy($id)
    {
        $success = (new DestroyBlogPost)->handle($id);

        Flux::toast(
            variant: $success ? 'success' : 'danger',
            text: $success ? 'Blog Post deleted.' : 'Blog Post could not be deleted.',
            duration: 3000,
        );
    }

    #[Computed]
    public function posts()
    {
        $documents = Document::paginate(10);

        $views = DocumentView::select('document_id', DB::raw('COUNT(*) as views'))
            ->groupBy('document_id')
            ->pluck('views', 'document_id');

        foreach ($documents->items() as $document) {
            $document->views = $views->get($document->id, 0);
        }

        return $documents;
    }

    public function clearUploads()
    {
        $this->file = null;
        $this->images = [];
        $this->resetValidation();
    }
}
