<?php

namespace App\Livewire;

use App\Livewire\Traits\TableHelpers;
use App\Models\DocumentView;
use Flux\Flux;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Blog extends Component
{
    use TableHelpers;
    use WithFileUploads;
    use WithPagination;

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

    public function destroy($id)
    {
        $document = DB::connection('prezet')->table('documents')->find($id);

        if ($document) {
            try {
                /* delete the file */
                Storage::disk('prezet')->delete('content/'.$document->slug.'.md');

                /* delete the tags */
                DB::connection('prezet')->table('document_tags')->where('document_id', $id)->delete();

                /* delete the reference */
                Document::where('id', $id)->delete();

                /* delete the views */
                DocumentView::where('document_id', $id)->delete();

                /* Index the sqlite db */
                Artisan::call('prezet:index');

            } catch (Exception) {
                Flux::toast(variant: 'danger', text: 'Blog Post could not be deleted.', duration: 3000);
            }

            Flux::toast(variant: 'success', text: 'Blog Post deleted.', duration: 3000);
        }
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
}
