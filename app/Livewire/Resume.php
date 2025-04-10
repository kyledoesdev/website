<?php

namespace App\Livewire;

use App\Models\Asset;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Resume extends Component
{
    use WithFileUploads;

    #[Validate('required|file|mimes:pdf')]
    public $resume;

    public function render()
    {
        return view('livewire.resume');
    }

    public function store()
    {
        $this->validate();

        $name = now()->format('Y-m-d') . '-resume.' . $this->resume->getClientOriginalExtension();

        $path = $this->resume->storePubliclyAs('resumes', $name, 's3');

        Asset::create([
            'type_id' => Asset::RESUME,
            'slug' => now()->format('Y-m-d') . '-resume',
            'name' => $name,
            'path' => $path,
            'mime_type' => $this->resume->getClientOriginalExtension()
        ]);

        $this->reset();

        Flux::toast(variant: 'success', text: 'Photo Uploaded!', duration: 3000);
    }

    public function destroy($id)
    {
        $resume = Asset::findOrFail($id);

        if (Storage::disk('s3')->exists($resume->path)) {            
            Storage::disk('s3')->delete($resume->path);
        }

        $resume->delete();

        Flux::toast(variant: 'success', text: 'Resume deleted!', duration: 3000);
    }

    #[Computed]
    public function resumes()
    {
        return Asset::where('type_id', Asset::RESUME)->get();
    }
}
