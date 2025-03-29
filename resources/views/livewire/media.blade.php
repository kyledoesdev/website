<div>
    <x-slot name="header">{{ $mediaType->name }}</x-slot>

    <div class="space-y-4">
        <livewire:panels :type="$mediaType->isMovie() ? 'movies' : 'tv'" :header="$mediaType->name" />

        <flux:card>
            <div class="flex justify-between">
                <div class="font-semibold text-xl leading-tight mt-2">
                    <h5>{{ $mediaType->isMovie() ? 'Add Movies' : "Add TV Shows" }}</h5>
                </div>
                <div>
                    <flux:modal.trigger name="create-media">
                        <flux:button variant="primary" size="sm">Create</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            {{-- Table of Media Type --}}
            <div class="py-6">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden shadow-2xs sm:rounded-lg p-6">
                        <flux:table :paginate="$this->medias">
                            @forelse ($this->medias as $media)
                                @if ($loop->first)
                                    <flux:table.columns>
                                        <flux:table.column>Name</flux:table.column>
                                        <flux:table.column>Favorite</flux:table.column>
                                        @if ($media->type_id == App\Models\MediaType::TV)
                                            <flux:table.column>Watching</flux:table.column>
                                        @endif
                                        <flux:table.column>Backlog</flux:table.column>
                                        <flux:table.column>Completed</flux:table.column>
                                        <flux:table.column>Actions</flux:table.column>
                                    </flux:table.columns>
                                @endif
        
                                <flux:table.row :key="$media->getKey()">
                                    <flux:table.cell>
                                        {{ $media->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($media->is_favorite)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    @if ($media->type_id == App\Models\MediaType::TV)
                                        <flux:table.cell>
                                            @if ($media->is_active)
                                                <flux:icon.check size="micro" />
                                            @else
                                                <flux:icon.x-mark size="micro" />
                                            @endif
                                        </flux:table.cell>
                                    @endif
                                    <flux:table.cell>
                                        @if ($media->in_backlog)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($media->is_completed)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:dropdown>
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />

                                            <flux:menu>
                                                <flux:menu.item
                                                    icon="pencil"
                                                    wire:click="edit({{ $media->getKey() }})"
                                                >
                                                    Edit
                                                </flux:menu.item>
                                                <flux:menu.item
                                                    icon="trash"
                                                    wire:click="destroy({{ $media->getKey() }})"
                                                    wire:confirm="Are you sure you want to delete this {{ $mediaType->name }}?"
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
                                        <flux:badge>No {{ $mediaType->name }} found.</flux:badge>
                                    </div>
                                </flux:card>
                            @endforelse
                        </flux:table>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <flux:modal name="create-media" class="space-y-6 md:w-1/2 md:h-full">
        @if (is_null($selectedMedia))
            <div class="mb-2">
                <flux:heading size="lg">Search MovieDB for a {{ $mediaType->name }}</flux:heading>
            </div>

            <flux:input.group>
                <flux:input wire:model="phrase" placeholder="Search..." required />

                <flux:button type="submit" icon="magnifying-glass" wire:click="search" />
            </flux:input.group>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($searchedMedia as $key => $media)
                    <div class="flex flex-col justify-center items-center space-y-2">
                        <div>
                            <img
                                width="142" 
                                height="190"
                                class="rounded-xl"
                                src="{{ $media['cover'] }}"
                                alt="{{ $media['name'] }}"
                            />
                        </div>

                        <div>
                            <flux:button 
                                variant="ghost"
                                size="sm"
                                icon="plus"
                                wire:click="selectMedia({{ $media['media_id'] }})"
                            >
                                Select {{ $mediaType->name }}
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="space-y-5">
                <div>
                    <flux:heading size="lg">Add {{ $selectedMedia['name'] }} to the {{ $mediaType->name }} list.</flux:heading>
                </div>

                <div>
                    <flux:checkbox.group wire:model.live="form.states">
                        <flux:checkbox label="Is Favorite?" value="is_favorite" />
                        <flux:checkbox label="Currently Watching?" value="is_active" />
                        <flux:checkbox label="In Backlog?" value="in_backlog" />
                        <flux:checkbox label="Completed?" value="is_completed" />
                    </flux:checkbox.group>
                </div>

                <div>
                    <flux:button size="sm" variant="primary" icon="plus" wire:click="store">
                        Add {{ $selectedMedia['name'] }}
                    </flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    <flux:modal name="edit-media" class="space-y-6 md:w-1/2">
        <div>
            <flux:heading size="lg">Edit {{ $mediaType->name }}: {{ $form->media?->name }}.</flux:heading>
        </div>

        <form wire:submit="update">
            <div>
                <flux:checkbox.group wire:model.live="form.states">
                    <flux:checkbox label="Is Favorite?" value="is_favorite" />
                    <flux:checkbox label="Currently Watching?" value="is_active" />
                    <flux:checkbox label="In Backlog?" value="in_backlog" />
                    <flux:checkbox label="Completed?" value="is_completed" />
                </flux:checkbox.group>
            </div>
                    
            <div class="flex my-2">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="update">Update</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
