<div>
    <x-slot name="header">{{ $header }}</x-slot>

    <div class="my-2">
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4 mb-4">
            @forelse($this->photos as $photo)
                <flux:card>
                    <img
                        src="{{ route('asset', ['slug' => $photo->slug]) }}"
                        alt="{{ $photo->name }}"
                        {{-- disgusting ahhhh hack --}}
                        onload="if (this.naturalHeight > this.naturalWidth) { this.style.width = '50%'; }"
                    >

                    <div class="mt-1">
                        <div class="flex flex-col">
                            <div class="my-2">
                                <flux:text>{{ $photo->name }}</flux:text>

                                @if (!is_null($photo->description) && $photo->description !== '')
                                    <flux:text variant="subtle" class="text-xs">{{ $photo->description }}</flux:text>
                                @endif

                                <flux:text class="mt-2" size="sm">{{ $photo->captured_at ?? $photo->created_at }}</flux:text>
                            </div>
                        </div>

                        @if (auth()->check() && request()->routeIs('gallery.edit'))
                            <div class="flex justify-end my-2">
                                <flux:button
                                    variant="danger"
                                    size="xs"
                                    icon="trash"
                                    wire:click="destroy({{ $photo->getKey() }})" 
                                    wire:confirm="Are you sure you want to delete this photo?"
                                />
                            </div>
                        @endif 
                    </div>
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