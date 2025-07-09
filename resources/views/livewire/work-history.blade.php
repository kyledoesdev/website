<div>
    @auth
        <livewire:panels
            :type="'work_history'"
            :header="'Work History'"
        />
    @endauth
    
    @guest
        <x-slot name="header">My Work History</x-slot>

        <flux:card class="mt-4">
            <x-markdown-content :content="App\Models\Panel::where('name', 'work_history')->first()->content" />
        </flux:card>
    @endguest
</div>
