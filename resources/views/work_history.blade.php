<x-guest-layout>
    <x-slot name="header">My Work History</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'work_history')->first()->content" />
    </div>
</x-guest-layout>