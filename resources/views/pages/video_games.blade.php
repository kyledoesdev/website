<x-guest-layout>
    <x-slot name="header">Video Games</x-slot>

    <div class="space-y-4 mt-4">
        <flux:card>
            <x-markdown-content :content="App\Models\Panel::where('name', 'video_games')->first()->content" />
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="xl">
                Video Game Catalog
            </flux:heading>

            <flux:separator />

            <x-media-showcase 
                :collection="App\Models\VideoGame::all()"
                :is_favorite="true"
                :is_active="true"
                :in_backlog="true"
                :is_completed="true"
                :action="'Playing'"
            />
        </flux:card>
    </div>
</x-guest-layout>