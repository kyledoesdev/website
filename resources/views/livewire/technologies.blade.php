<div>
    {{-- Header & Create Model --}}
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

    {{-- Table of Episodes --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <flux:table :paginate="$this->technologies">
                    <flux:columns>
                        <flux:column sortable :sorted="$sortBy === 'icon'" :direction="$sortDirection" wire:click="sort('icon')">Icon</flux:column>
                        <flux:column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:column>
                        <flux:column sortable :sorted="$sortBy === 'description'" :direction="$sortDirection" wire:click="sort('description')">Description</flux:column>
                        <flux:column>Actions</flux:column>
                    </flux:columns>

                    <flux:rows>
                        @forelse ($this->technologies as $technology)
                            <flux:row :key="$technology->getKey()">
                                <flux:cell>
                                    <i class="text-4xl md:text-6xl px-1 {{ $technology->icon }}"></i>
                                </flux:cell>

                                <flux:cell>
                                    {{ $technology->name }}
                                </flux:cell>

                                <flux:cell>
                                    {{ $technology->description }}
                                </flux:cell>
                                
                                <flux:cell>
                                    <flux:dropdown>
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                        <flux:menu>
                                            <flux:menu.item icon="pencil" wire:click="edit('{{ $technology->getKey() }}')">Edit</flux:menu.item>
                                            <flux:menu.item icon="trash" wire:click="confirm('{{ $technology->getKey() }}')">Delete</flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>
                                </flux:cell>
                            </flux:row>
                        @empty
                            
                        @endforelse
                    </flux:rows>
                </flux:table>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <flux:modal name="create-technology" variant="flyout" class="space-y-6">
        <div>
            <flux:heading size="lg">Create a new Technology.</flux:heading>
        </div>

        <div class="py-2">
            <flux:input wire:model="createForm.name" label="Name" description="Name of the technology." />
        </div>

        <div class="py-2">
            <flux:input wire:model="createForm.description" label="Description" description="How long you've used the technology." />
        </div>

        <div class="py-2">
            <flux:input wire:model="createForm.icon" label="Icon Class Name" description="The class name of the decicon." />
        </div>
                
        <div class="flex my-2">
            <flux:spacer />
            <flux:button type="submit" variant="primary" wire:click="store">Create</flux:button>
        </div>
    </flux:modal>

    {{-- Edit Modal --}}
    <flux:modal name="edit-technology" variant="flyout" class="space-y-6" @close="$this->editForm->reset()">
        <div>
            <flux:heading size="lg">Edit Technology: {{ $this->editForm->name }}</flux:heading>
        </div>

        <form wire:submit="update">
            <div class="py-2">
                <flux:input wire:model="editForm.name" label="Name" description="Name of the technology." />
            </div>

            <div class="py-2">
                <flux:input wire:model="editForm.description" label="Description" description="How long you've used the technology." />
            </div>

            <div class="py-2">
                <flux:input wire:model="editForm.icon" label="Icon Class Name" description="The class name of the decicon." />
            </div>
                    
            <div class="flex my-2">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="update">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Destroy Confirm Modal --}}
    <flux:modal name="destroy-technology" class="md:w-96 space-y-6">
        <div>
            <flux:heading size="lg">Delete Technology: {{ $selectedTechnology?->name }}?</flux:heading>
            <flux:subheading>Are you sure you want to delete this technology?</flux:subheading>
        </div>

        <div class="flex">
            <flux:spacer />

            <form wire:submit="destroy">
                <flux:button type="submit" variant="danger" size="xs">Delete</flux:button>
            </form>
        </div>
    </flux:modal>
</div>