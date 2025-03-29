<x-guest-layout>
    <x-slot name="header">Board Games</x-slot>

    <flux:card class="mt-4">
        <x-markdown-content :content="App\Models\Panel::where('name', 'board_games')->first()->content" />
    </flux:card>

    {{-- todo --}}
</x-guest-layout>