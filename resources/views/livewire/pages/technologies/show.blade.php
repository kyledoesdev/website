<div>
    <x-slot name="header">Technologies</x-slot>

    <flux:card>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach ($technologies as $technology)
                <div
                    x-data="{ flipped: false }"
                    x-on:mouseenter="flipped = true"
                    x-on:mouseleave="flipped = false"
                    class="perspective-500 h-32"
                    wire:key="technology-{{ $technology->getKey() }}"
                >
                    <div
                        class="relative h-full w-full transition-transform duration-300 transform-3d"
                        :class="flipped ? 'rotate-y-180' : ''"
                    >
                        {{-- Front --}}
                        <div class="absolute inset-0 backface-hidden bg-zinc-100 dark:bg-zinc-700 rounded-lg shadow-md p-4 flex flex-col justify-center items-center">
                            <h5 class="text-center mb-2">{{ $technology->name }}</h5>
                            <flux:separator />
                            <i class="text-4xl md:text-6xl {{ $technology->icon }} mt-2"></i>
                        </div>

                        {{-- Back --}}
                        <div class="absolute inset-0 backface-hidden rotate-y-180 bg-zinc-100 dark:bg-zinc-700 rounded-lg shadow-md p-4 flex flex-col justify-center items-center">
                            <h5 class="text-center font-semibold mb-1">{{ $technology->name }}</h5>
                            <flux:separator />
                            <p class="text-center text-lg mt-2">{{ $technology->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </flux:card>
</div>
