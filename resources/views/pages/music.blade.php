<x-guest-layout>
    <x-slot name="header">Bands & Music</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'music')->first()->content" />
    </div>

    {{-- todo --}}
</x-guest-layout>