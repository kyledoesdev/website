<x-guest-layout>
    <x-slot name="header">Projects</x-slot>

    <div class="mt-4">
        <x-markdown-content :content="App\Models\Panel::where('name', 'projects')->first()->content" />
    </div>
</x-guest-layout>