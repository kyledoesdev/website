<div>
    <x-slot name="header">{{ $header }}</x-slot>

    <div class="my-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 mb-4">
            @forelse($this->photos as $photo)
                <flux:card>
                    <div class="flex flex-col items-center">
                        <img
                            src="{{ route('asset', ['slug' => $photo->slug]) }}"
                            alt="{{ $photo->name }}"
                            style="width: auto; height: auto; max-width: 100%;"
                            {{-- disgusting ahhhh hack --}}
                            onload="if (this.naturalHeight > this.naturalWidth) { this.style.width = '50%'; }"
                        >

                        <div class="my-2 text-center">
                            <flux:text>{{ $photo->name }} - {{ $photo->captured_at }}</flux:text>
                        </div>

                        <div>
                            <flux:text variant="subtle" class="text-xs">{{ $photo->description }}</flux:text>
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
            @empty
                <flux:card>
                    <flux:badge>{{ $emptyMessage }}</flux:badge>
                </flux:card>
            @endforelse
        </div>
    </div>


    <flux:pagination :paginator="$this->photos" />
</div>