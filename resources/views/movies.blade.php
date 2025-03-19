<x-guest-layout>
    <x-slot name="header">Movies</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'movies')->first()->content" />
    </div>

    {{-- todo --}}
</x-guest-layout>