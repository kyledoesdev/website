<x-guest-layout>
    <x-slot name="header">Board Games</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'board_games')->first()->content" />
    </div>

    {{-- todo --}}
</x-guest-layout>