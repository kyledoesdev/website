<div>
    <x-slot name="header">Movies</x-slot>

    <div class="space-y-4">
        <livewire:panels :type="'movies'" :header="'Movies'" />

        <flux:card>
            <div class="flex justify-between">
                <div class="font-semibold text-xl leading-tight mt-2">
                    <h5>Add Movies</h5>
                </div>
                <div>
                    <flux:modal.trigger name="create-media">
                        <flux:button variant="primary" size="sm">Create</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            {{-- Table of Media Type --}}
            <div class="py-2">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden shadow-2xs sm:rounded-lg">
                        <div class="flex justify-end items-center gap-2 w-full my-2">
                            <x-per-page-selector />
                            <flux:input
                                size="sm"
                                wire:model.live.debounce.500ms="search"
                                icon-trailing="magnifying-glass"
                                class="w-full md:w-1/4"
                            />
                        </div>

                        <flux:table :paginate="$this->medias">
                            <flux:table.columns>
                                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
                                @foreach ($states as $state)
                                    <flux:table.column sortable :sorted="$sortBy === $state->value" :direction="$sortDirection" wire:click="sort('{{ $state->value }}')">{{ $state->label() }}</flux:table.column>
                                @endforeach
                                <flux:table.column>Actions</flux:table.column>
                            </flux:table.columns>

                            @forelse ($this->medias as $media)
                                <flux:table.row :key="$media->getKey()">
                                    <flux:table.cell>
                                        {{ $media->name }}
                                    </flux:table.cell>
                                    @foreach ($states as $state)
                                        <flux:table.cell>
                                            <flux:checkbox
                                                :checked="$state->getValue($media)"
                                                wire:click="toggleState({{ $media->getKey() }}, '{{ $state->value }}')"
                                            />
                                        </flux:table.cell>
                                    @endforeach
                                    <flux:table.cell>
                                        <flux:button
                                            variant="danger"
                                            size="sm"
                                            icon="trash"
                                            inset="top bottom"
                                            wire:click="destroy({{ $media->getKey() }})"
                                            wire:confirm="Are you sure you want to delete this movie?"
                                        />
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:card>
                                    <div class="flex justify-center my-4">
                                        <flux:badge>No Movies found.</flux:badge>
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
                <flux:heading size="lg">Search MovieDB for a Movie</flux:heading>
            </div>

            <flux:input.group>
                <flux:input wire:model="phrase" placeholder="Search..." required />

                <flux:button type="submit" icon="magnifying-glass" wire:click="searchMedia" />
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
                                Select Movie
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="space-y-5">
                <div>
                    <flux:heading size="lg">Add {{ $selectedMedia['name'] }} to the movies list.</flux:heading>
                </div>

                <div>
                    <flux:checkbox.group wire:model.live="form.states">
                        @foreach ($states as $state)
                            <flux:checkbox label="{{ $state->label() }}?" value="{{ $state->value }}" />
                        @endforeach
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

</div>
