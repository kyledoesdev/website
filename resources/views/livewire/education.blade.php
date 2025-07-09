<div>
    @auth
        <livewire:panels
            :type="'education'"
            :header="'Education'"
        />
    @endauth

    @guest
        <x-slot name="header">How I Started</x-slot>

        <flux:card class="mt-4">
            <x-markdown-content :content="App\Models\Panel::where('name', 'education')->first()->content" />
        </flux:card>
    @endguest
</div>
