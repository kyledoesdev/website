<x-guest-layout>
    <x-slot name="header">Projects</x-slot>

    <flux:card class="mt-4">
        <x-markdown-content :content="App\Models\Panel::where('name', 'projects')->first()->content" />
    </flux:card>
</x-guest-layout>