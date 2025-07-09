<div>
    <x-slot name="header">Technologies</x-slot>

    @auth
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
                                        <flux:table.column>Actions</flux:table.column>
                                    </flux:table.columns>
                                @endif
        
                                <flux:table.row :key="$technology->getKey()">
                                    <flux:table.cell>
                                        <i class="text-4xl md:text-6xl px-1 {{ $technology->icon }}"></i>
                                    </flux:table.cell>
        
                                    <flux:table.cell>
                                        {{ $technology->name }}
                                    </flux:table.cell>
        
                                    <flux:table.cell>
                                        {{ $technology->description }}
                                    </flux:table.cell>
                                    
                                    <flux:table.cell>
                                        <flux:dropdown>
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
        
                                            <flux:menu>
                                                <flux:menu.item icon="pencil" wire:click="edit('{{ $technology->getKey() }}')">Edit</flux:menu.item>
                                                <flux:menu.item
                                                    icon="trash"
                                                    wire:click="destroy('{{ $technology->getKey() }}')"
                                                    wire:confirm="Are you sure you want to delete this technology?"
                                                >
                                                    Delete
                                                </flux:menu.item>
                                            </flux:menu>
                                        </flux:dropdown>
                                    </flux:table.cell>
                                </flux:table.row>
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
    @endauth

    @guest
        <flux:card>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach (App\Models\Technology::all() as $technology)
                    <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg shadow-md p-4">
                        <div class="flex justify-center items-center">
                            <h5 class="text-center mb-2">{{ $technology->name }}</h5>
                        </div>
                        <flux:separator />
                        <div class="flex justify-center items-center">
                            <i class="text-4xl md:text-6xl {{ $technology->icon }} mt-2"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        </flux:card>
    @endguest
</div>