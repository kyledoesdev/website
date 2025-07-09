<div>
    <x-slot name="header">Board Games</x-slot>

    @auth
        <livewire:panels
            :type="'board_games'"
            :header="'Board Games'"
        />
    @endauth

    @guest
        <flux:card class="mt-4">
            <x-markdown-content :content="App\Models\Panel::where('name', 'board_games')->first()->content" />
        </flux:card>
    @endguest
</div>
