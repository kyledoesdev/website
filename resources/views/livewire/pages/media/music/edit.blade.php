<div>
    <div class="space-y-4">
        <livewire:panels :type="'music'" :header="'Bands & Music'" />

        <flux:card>
            <div class="flex justify-between">
                <div class="font-semibold text-xl leading-tight mt-2">
                    <h5>Favorite Artists</h5>
                </div>
                <div>
                    <flux:modal.trigger name="create-artist">
                        <flux:button variant="primary" size="sm">Create</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            {{-- Table of Artists --}}
            <div class="py-2">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden shadow-2xs sm:rounded-lg">
                        <div class="flex justify-end w-full">
                            <flux:input 
                                size="sm"
                                wire:model.live.debounce.500ms="searchArtists"
                                icon-trailing="magnifying-glass"
                                class="my-2 w-full md:w-1/4"
                            />
                        </div>

                        <flux:table :paginate="$this->artists">
                            @forelse ($this->artists as $artist)
                                @if ($loop->first)
                                    <flux:table.columns>
                                        <flux:table.column>Name</flux:table.column>
                                        <flux:table.column>Actions</flux:table.column>
                                    </flux:table.columns>
                                @endif
        
                                <flux:table.row :key="$artist->getKey()">
                                    <flux:table.cell>
                                        {{ $artist->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:dropdown>
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />

                                            <flux:menu>
                                                <flux:menu.item
                                                    icon="trash"
                                                    wire:click="destroy({{ $artist->getKey() }})"
                                                    wire:confirm="Are you sure you want to delete this Artist?"
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
                                        <flux:badge>No Artists found.</flux:badge>
                                    </div>
                                </flux:card>
                            @endforelse
                        </flux:table>
                    </div>
                </div>
            </div>
        </flux:card>

        <flux:card>
            <div class="flex justify-between">
                <div class="font-semibold text-xl leading-tight mt-2">
                    <h5>Favorite Tracks</h5>
                </div>
                <div>
                    <flux:modal.trigger name="create-track">
                        <flux:button variant="primary" size="sm">Create</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            {{-- Table of Tracks --}}
            <div class="py-2">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden shadow-2xs sm:rounded-lg">
                        <div class="flex justify-end w-full">
                            <flux:input 
                                size="sm"
                                wire:model.live.debounce.500ms="searchTracks"
                                icon-trailing="magnifying-glass"
                                class="my-2 w-full md:w-1/4"
                            />
                        </div>

                        <flux:table :paginate="$this->tracks">
                            @forelse ($this->tracks as $track)
                                @if ($loop->first)
                                    <flux:table.columns>
                                        <flux:table.column>Track</flux:table.column>
                                        <flux:table.column>Artist</flux:table.column>
                                        <flux:table.column>Album</flux:table.column>
                                        <flux:table.column>Actions</flux:table.column>
                                    </flux:table.columns>
                                @endif
        
                                <flux:table.row :key="$track->getKey()">
                                    <flux:table.cell>
                                        {{ $track->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $track->data['artist_name'] }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $track->data['album_name'] }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:dropdown>
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />

                                            <flux:menu>
                                                <flux:menu.item
                                                    icon="trash"
                                                    wire:click="destroy({{ $track->getKey() }})"
                                                    wire:confirm="Are you sure you want to delete this Track?"
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
                                        <flux:badge>No Tracks found.</flux:badge>
                                    </div>
                                </flux:card>
                            @endforelse
                        </flux:table>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <flux:modal name="create-artist" class="space-y-6 md:w-1/2 md:h-full">
        <div class="mb-2">
            <flux:heading size="lg">Search Spotify for an Artist</flux:heading>
        </div>

        <flux:input.group>
            <flux:input wire:model="phrase" placeholder="Search..." required />

            <flux:button
                type="submit"
                icon="magnifying-glass"
                wire:click="search({{ $mediaTypes->firstWhere('name', 'Artist')->getKey() }})"
            />
        </flux:input.group>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($searchedMedia as $key => $media)
                <div class="flex flex-col justify-center items-center space-y-2">
                    <div>
                        <img
                            width="640" 
                            height="480"
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
                            wire:click="store('{{ $media['media_id'] }}')"
                        >
                            Add Artist
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:modal>

    <flux:modal name="create-track" class="space-y-6 md:w-1/2 md:h-full">
        <div class="mb-2">
            <flux:heading size="lg">Search Spotify for a Track</flux:heading>
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
                            wire:click="store('{{ $media['media_id'] }}')"
                        >
                            Add Track
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:modal>
</div>