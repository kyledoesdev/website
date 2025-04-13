<div>
    <x-slot name="header">Bands & Music</x-slot>

    <div class="space-y-6 mt-4">
        {{-- Markdown content --}}
        <flux:card>
            <x-markdown-content :content="$panel" />
        </flux:card>

        {{-- spotify showcase --}}
        <flux:card class="space-y-4">
            <flux:heading class="mb-4" size="xl">
                My favorite artists & tracks
            </flux:heading>

            <flux:separator />

            <x-spotify-showcase 
                :favoriteArtists="$favoriteArtists"
                :favoriteTracks="$favoriteTracks"
            />
        </flux:card>

        {{-- additional content --}}
        <flux:card class="space-y-4">
            <flux:heading size="xl">
                Additional Content
            </flux:heading>

            <flux:separator />

            <flux:accordion transition>
                <flux:accordion.item>
                    <flux:accordion.heading>
                        My vinyl record collection
                    </flux:accordion.heading>
                    <flux:accordion.content>
                        <div class="flex" style="max-width: 100%; overflow-x: auto;">
                            <iframe
                                class="mt-4"
                                width="560"
                                height="315"
                                src="https://www.youtube.com/embed/ldyNdNMZ7SY?si=xeH05ne2VXp95D4t"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </flux:accordion.content>
                </flux:accordion.item>
                <flux:accordion.item>
                    <flux:accordion.heading>
                        Canvas print of my favorite bands
                    </flux:accordion.heading>
                    <flux:accordion.content>
                        <a target="_blank" href="{{ asset('music_canvas.jpg') }}">
                            <img 
                                class="h-[240px] object-contain rounded-xl"
                                src="{{ asset('music_canvas.jpg') }}"
                                alt="canvas print of kyle's favorite bands"
                            />
                        </a>
                    </flux:accordion.content>
                </flux:accordion.item>
                <flux:accordion.item>
                    <flux:accordion.heading>
                        My setlist.fm profile
                    </flux:accordion.heading>
                    <flux:accordion.content>
                        <a target="_blank" href="https://www.setlist.fm/user/spacelampsix" class="text-xl text-blue-500 underline">
                            setlist.fm
                        </a>
                    </flux:accordion.content>
                </flux:accordion.item>
                <flux:accordion.item>
                    <flux:accordion.heading>
                        songrank.dev 🎵
                    </flux:accordion.heading>
                    <flux:accordion.content>
                        <a target="_blank" href="https://songrank.dev" class="text-xl text-blue-500 underline">
                            songrank.dev
                        </a>
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </flux:card>
    </div>
</div>
