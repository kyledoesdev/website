<div>
    <x-slot name="header">Technologies</x-slot>

    {{-- Header & Create Model --}}
    <flux:card>
        <div class="flex justify-between">
            <div class="font-semibold text-xl leading-tight mt-2">
                <h5>Technologies</h5>
            </div>
            <div>
                <flux:modal.trigger name="create-technology">
                    <flux:button variant="primary" size="sm">Create</flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        {{-- Table of Technologies --}}
        <div class="py-6">
            <div class="max-w-7xl mx-auto">
                <div class="overflow-hidden shadow-2xs sm:rounded-lg p-6">
                    <flux:table :paginate="$this->technologies">
                        @forelse ($this->technologies as $technology)
                            @if ($loop->first)
                                <flux:table.columns>
                                    <flux:table.column sortable :sorted="$sortBy === 'icon'" :direction="$sortDirection" wire:click="sort('icon')">Icon</flux:table.column>
                                    <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                                    <flux:table.column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection" wire:click="sort('description')">Description</flux:table.column>
                                    <flux:table.column>Icon Class</flux:table.column>
                                    <flux:table.column>Actions</flux:table.column>
                                </flux:table.columns>
                            @endif

                            <livewire:pages.technologies.tables.row
                                :technology="$technology"
                                :wire:key="$technology->getKey()"
                            />
                        @empty
                            <flux:card>
                                <div class="flex justify-center my-4">
                                    <flux:badge>No Technologies found.</flux:badge>
                                </div>
                            </flux:card>
                        @endforelse
                    </flux:table>
                </div>
            </div>
        </div>
    </flux:card>

    {{-- Create Modal --}}
    <flux:modal name="create-technology" variant="flyout" class="space-y-6">
        <div>
            <flux:heading size="lg">Create a new Technology.</flux:heading>
        </div>

        <div class="py-2">
            <flux:input
                wire:model="createForm.name"
                label="Name"
                description="Name of the technology."
            />
        </div>

        <div class="py-2">
            <flux:input
                wire:model="createForm.description"
                label="Description"
                description="How long you've used the technology."
            />
        </div>

        <div class="py-2">
            <flux:input
                wire:model="createForm.icon"
                label="Icon Class Name"
                description="The class name of the decicon."
            />
        </div>

        <div class="flex my-2">
            <flux:spacer />
            <flux:button type="submit" variant="primary" wire:click="store">Create</flux:button>
        </div>
    </flux:modal>
</div>
