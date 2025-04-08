<div>
    <x-slot name="header">Resume</x-slot>

    <div class="space-y-8">
        <flux:card class="space-y-2">
            <flux:input type="file" wire:model="resume" label="New Resume Upload"/>

            <flux:button variant="primary" size="xs" icon="arrow-up-tray" wire:click="store">Upload</flux:button>
        </flux:card>

        <flux:card class="space-y-4">
            <div>
                <span>Previous Resumes:</span>
            </div>

            <div>
                @foreach ($this->resumes as $resume)
                    <a class="underline text-blue-300 my-2" href="{{ $resume->full_path }}" target="_blank">{{ $resume->name }}</a>
                @endforeach
            </div>
        </flux:card>
    </div>
</div>
