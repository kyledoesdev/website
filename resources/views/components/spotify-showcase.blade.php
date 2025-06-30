@props([
    'favoriteArtists',
    'favoriteTracks',
])

<flux:accordion transition>
    <flux:accordion.item>
        <flux:accordion.heading>
            My Favorite Artists
        </flux:accordion.heading>
        <flux:accordion.content>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-10 gap-4 space-x-4 space-y-1 text-center my-2" style="max-height: 400px; overflow-y:auto;">
                @foreach ($favoriteArtists as $artist)
                    <div class="flex flex-col">
                        <div class="text-center p-2 md:p-0 min-w-full">
                            <img
                                class="w-32 h-32 rounded-lg object-contain text-center"
                                src="{{ $artist->cover }}"
                                alt="{{ $artist->name }}"
                            />
                        </div>
    
                        <flux:text>{{ $artist->name }}</flux:text>
                    </div>
                @endforeach
            </div>

            <flux:pagination :paginator="$favoriteArtists" wire:click="setArtistsPage($event.page)" />
        </flux:accordion.content>
    </flux:accordion.item>
    <flux:accordion.item>
        <flux:accordion.heading>
            My Favorite Tracks
        </flux:accordion.heading>
        <flux:accordion.content>
            <div class="flex justify-center mb-2" style="max-height: 400px; overflow-y:auto;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 space-x-4 space-y-1 mt-2">
                    @foreach ($favoriteTracks as $track)
                        <iframe
                            src="https://open.spotify.com/embed/track/{{ $track->media_id }}"
                            class="rounded-xl max-h-20"
                            frameborder="0" 
                            allowtransparency="true" 
                            allow="encrypted-media"
                        ></iframe>
                    @endforeach
                </div>
            </div>

            {{-- <flux:pagination :paginator="$favoriteTracks" wire:click="setTracksPage($event.page)"  /> --}}
        </flux:accordion.content>
    </flux:accordion.item>
</flux:accordion>