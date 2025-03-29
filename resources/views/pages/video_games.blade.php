<x-guest-layout>
    <x-slot name="header">Video Games</x-slot>

    <div class="space-y-4 mt-8">
        <flux:card>
            <x-markdown-content :content="App\Models\Panel::where('name', 'video_games')->first()->content" />
        </flux:card>

        <flux:card>
            <x-media-showcase 
                :collection="App\Models\VideoGame::all()"
                :is_favorite="true"
                :is_active="true"
                :in_backlog="true"
                :is_completed="true"
            />
        </flux:card>
    </div>
</x-guest-layout>