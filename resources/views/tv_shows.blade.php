<x-guest-layout>
    <x-slot name="header">TV Shows</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'tv')->first()->content" />
    </div>

    {{-- todo --}}
</x-guest-layout>