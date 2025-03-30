<div>
    <x-slot name="header">Video Games</x-slot>

    <div class="space-y-4">
        <livewire:panels :type="'video_games'" :header="'Video Games'" />

        <flux:card>
            <div class="flex justify-between">
                <div class="font-semibold text-xl leading-tight mt-2">
                    <h5>Video Games</h5>
                </div>
                <div>
                    <flux:modal.trigger name="create-video_game">
                        <flux:button variant="primary" size="sm">Create</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        
            {{-- Table of Games --}}
            <div class="py-6">
                <div class="max-w-7xl mx-auto">
                    <div class="overflow-hidden shadow-2xs sm:rounded-lg p-6">
                        <flux:table :paginate="$this->games">
                            @forelse ($this->games as $game)
                                @if ($loop->first)
                                    <flux:table.columns>
                                        <flux:table.column>Name</flux:table.column>
                                        <flux:table.column>Favorite</flux:table.column>
                                        <flux:table.column>Playing</flux:table.column>
                                        <flux:table.column>Backlog</flux:table.column>
                                        <flux:table.column>Completed</flux:table.column>
                                        <flux:table.column>Actions</flux:table.column>
                                    </flux:table.columns>
                                @endif
        
                                <flux:table.row :key="$game->getKey()">
                                    <flux:table.cell>
                                        {{ $game->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($game->is_favorite)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($game->is_active)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($game->in_backlog)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if ($game->is_completed)
                                            <flux:icon.check size="micro" />
                                        @else
                                            <flux:icon.x-mark size="micro" />
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:dropdown>
                                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                            <flux:menu>
                                                <flux:menu.item
                                                    icon="pencil"
                                                    wire:click="edit({{ $game->getKey() }})"
                                                >
                                                    Edit
                                                </flux:menu.item>
                                                <flux:menu.item
                                                    icon="trash"
                                                    wire:click="destroy({{ $game->getKey() }})"
                                                    wire:confirm="Are you sure you want to delete this game?"
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
                                        <flux:badge>No Video Games found.</flux:badge>
                                    </div>
                                </flux:card>
                            @endforelse
                        </flux:table>
                    </div>
                </div>
            </div>
        </flux:card>
    </div>

    <flux:modal name="create-video_game" class="space-y-6 md:w-1/2 md:h-full">
        @if (is_null($selectedGame))
            <div class="mb-2">
                <flux:heading size="lg">Search Twitch for a Game Category</flux:heading>
            </div>

            <flux:input.group>
                <flux:input wire:model="phrase" placeholder="Search..." required />

                <flux:button type="submit" icon="magnifying-glass" wire:click="search" />
            </flux:input.group>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($searchedGames as $key => $game)
                    <div class="flex flex-col justify-center items-center space-y-2">
                        <div>
                            <img
                                width="142" 
                                height="190"
                                class="rounded-xl"
                                src="{{ $game['cover'] }}"
                                alt="{{ $game['name'] }}"
                            />
                        </div>

                        <div>
                            <flux:button 
                                variant="ghost"
                                size="sm"
                                icon="plus"
                                wire:click="selectGame({{ $game['media_id'] }})"
                            >
                                Select Game
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="space-y-5">
                <div>
                    <flux:heading size="lg">Add {{ $selectedGame['name'] }} to games list.</flux:heading>
                </div>
    
                <div>
                    <flux:checkbox.group wire:model.live="form.states">
                        <flux:checkbox label="Is Favorite?" value="is_favorite" />
                        <flux:checkbox label="Currently Playing?" value="is_active" />
                        <flux:checkbox label="In Backlog?" value="in_backlog" />
                        <flux:checkbox label="Completed?" value="is_completed" />
                    </flux:checkbox.group>
                </div>

                <div>
                    <flux:button size="sm" variant="primary" icon="plus" wire:click="store">
                        Add {{ $selectedGame['name'] }}
                    </flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    <flux:modal name="edit-video_game" class="space-y-6 md:w-1/2">
        <div>
            <flux:heading size="lg">Edit video game: {{ $form->media?->name }}.</flux:heading>
        </div>

        <form wire:submit="update">
            <div>
                <flux:checkbox.group wire:model.live="form.states">
                    <flux:checkbox label="Is Favorite?" value="is_favorite" />
                    <flux:checkbox label="Currently Playing?" value="is_active" />
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
