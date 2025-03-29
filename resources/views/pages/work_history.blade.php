<x-guest-layout>
    <x-slot name="header">My Work History</x-slot>

    <flux:card class="mt-4">
        <x-markdown-content :content="App\Models\Panel::where('name', 'work_history')->first()->content" />
    </flux:card>
</x-guest-layout>