<x-guest-layout>
    <x-slot name="header">Video Games</x-slot>

    <div class="mt-8">
        <x-markdown-content :content="App\Models\Panel::where('name', 'video_games')->first()->content" />
    </div>

    {{-- todo --}}
</x-guest-layout>