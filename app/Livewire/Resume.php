<?php

namespace App\Livewire;

use App\Models\Resume as ResumeModel;
use Flux\Flux;
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

        $name = "kyle_evangelisto_" . now()->format('Y_m_d') . '_resume.' . $this->resume->getClientOriginalExtension();

        $path = $this->resume->storePubliclyAs('resumes', $name, 'public');

        ResumeModel::create([
            'name' => $name,
            'path' => $path
        ]);

        $this->reset();

        Flux::toast(variant: 'success', text: 'Photo Uploaded!', duration: 3000);
    }

    #[Computed]
    public function resumes()
    {
        return ResumeModel::all();
    }
}
