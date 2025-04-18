<x-guest-layout>
    <x-slot name="header">Technologies</x-slot>
    
    <flux:card>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach (App\Models\Technology::all() as $technology)
                <div class="bg-zinc-100 dark:bg-zinc-700 rounded-lg shadow-md p-4">
                    <div class="flex justify-center items-center">
                        <h5 class="text-center mb-2">{{ $technology->name }}</h5>
                    </div>
                    <flux:separator />
                    <div class="flex justify-center items-center">
                        <i class="text-4xl md:text-6xl {{ $technology->icon }} mt-2"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:card>
</x-guest-layout>