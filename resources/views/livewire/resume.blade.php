<div>
    <x-slot name="header">Resume</x-slot>

    <div class="space-y-8">
        <flux:card class="space-y-2">
            <flux:input type="file" wire:model="resume" label="New Resume Upload"/>

            <flux:button variant="primary" size="xs" icon="arrow-up-tray" wire:click="store">Upload</flux:button>
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading>
                Resumes
            </flux:heading>

            <div>
                <flux:table>
                    @forelse ($this->resumes as $resume)
                        @if ($loop->first)
                            <flux:table.columns>
                                <flux:table.column>Resume</flux:table.column>
                                <flux:table.column>Action</flux:table.column>
                            </flux:table.columns>
                        @endif

                        <flux:table.rows>
                            <flux:table.row>
                                <flux:table.columns>
                                    <flux:table.column>
                                        <a class="underline text-blue-300 my-2" href="{{ $resume->full_path }}" target="_blank">{{ $resume->name }}</a>
                                    </flux:table.column>
                                    <flux:table.column>
                                        <flux:button
                                            variant="danger"
                                            size="sm"
                                            icon="trash"
                                            wire:click="destroy({{ $resume->id }})"
                                            wire:confirm="Are you sure you want to delete this resume?"
                                        />
                                    </flux:table.column>
                                </flux:table.columns>
                            </flux:table.row>
                        </flux:table.rows>
                    @empty
                        <flux:badge>No Resumes</flux:badge>
                    @endforelse
                </flux:table>
            </div>
        </flux:card>
    </div>
</div>
