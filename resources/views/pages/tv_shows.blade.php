<x-guest-layout>
    <x-slot name="header">TV Shows</x-slot>

    <div class="space-y-4 mt-8">
        <flux:card>
            <x-markdown-content :content="App\Models\Panel::where('name', 'tv')->first()->content" />
        </flux:card>

        <flux:card>
            <x-media-showcase 
                :collection="App\Models\Media::where('type_id', App\Models\MediaType::TV)->get()"
                :is_favorite="true"
                :is_active="true"
                :in_backlog="true"
                :is_completed="true"
                :action="'Watching'"
            />
        </flux:card>
    </div>
</x-guest-layout>