<x-guest-layout>
    <x-slot name="header">My Work History</x-slot>

    <x-markdown-content :content="App\Models\Panel::where('name', 'work_history')->first()->content" />
</x-guest-layout>