<x-guest-layout>
    <x-slot name="header">How I Started</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'education')->first()->content" />
    </div>
</x-guest-layout>