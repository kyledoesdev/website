<x-guest-layout>
    <x-slot name="header">How I Started</x-slot>

    <x-markdown-content :content="App\Models\Panel::where('name', 'education')->first()->content" />
</x-guest-layout>