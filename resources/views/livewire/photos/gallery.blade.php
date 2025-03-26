<div>
    <x-slot name="header">Cool Photos</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 space-y-4 mt-4 mb-4">
        @foreach ($this->photos as $photo)
            <flux:card>
                <div class="flex flex-col items-center">
                    <img src="{{ $photo->path }}" alt="{{ $photo->name }}">

                    <div class="my-2 text-center">
                        <span>{{ $photo->name }} - {{ $photo->captured_at->format('F d, Y') }}</span>
                    </div>
                </div>

                @auth
                    <div class="flex justify-center">
                        <flux:button
                            variant="danger"
                            size="sm"
                            icon="trash"
                            wire:click="destroy({{ $photo->getKey() }})" 
                            wire:confirm="Are you sure you want to delete this photo?"
                        />
                    </div>
                @endauth
            </flux:card>
        @endforeach
    </div>

    <flux:pagination :paginator="$this->photos" />
</div>