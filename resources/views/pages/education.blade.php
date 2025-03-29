<x-guest-layout>
    <x-slot name="header">How I Started</x-slot>

    <flux:card class="mt-4">
        <x-markdown-content :content="App\Models\Panel::where('name', 'education')->first()->content" />
    </flux:card>
</x-guest-layout>