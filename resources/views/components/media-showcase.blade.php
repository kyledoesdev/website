@props([
    'collection',
    'is_favorite',
    'is_active',
    'in_backlog',
    'is_completed',
    'action'
])

<flux:accordion transition>
    @if ($is_favorite)
        <flux:accordion.item>
            <flux:accordion.heading>
                My Favorites
            </flux:accordion.heading>
            <flux:accordion.content>
                <div class="flex space-x-4 space-y-1">
                    @foreach ($collection->where('is_favorite', true) as $item)
                        <x-content-art :image="$item->cover" :title="$item->name" />
                    @endforeach
                </div>
            </flux:accordion.content>
        </flux:accordion.item>
    @endif
    @if ($is_active)
        <flux:accordion.item>
            <flux:accordion.heading>
                Currently {{ $action ?? 'doing' }}
            </flux:accordion.heading>
            <flux:accordion.content>
                <div class="flex space-x-4 space-y-1">
                    @foreach ($collection->where('is_active', true) as $item)
                        <x-content-art :image="$item->cover" :title="$item->name" />
                    @endforeach
                </div>
            </flux:accordion.content>
        </flux:accordion.item>
    @endif
    @if ($in_backlog)
        <flux:accordion.item>
            <flux:accordion.heading>
                In Backlog
            </flux:accordion.heading>
            <flux:accordion.content>
                <div class="flex space-x-4 space-y-1">
                    @foreach ($collection->where('in_backlog', true) as $item)
                        <x-content-art :image="$item->cover" :title="$item->name" />
                    @endforeach
                </div>
            </flux:accordion.content>
        </flux:accordion.item>
    @endif
    @if ($is_completed)
        <flux:accordion.item>
            <flux:accordion.heading>
                Completed
            </flux:accordion.heading>
            <flux:accordion.content>
                <div class="flex space-x-4 space-y-1">
                    @foreach ($collection->where('is_completed', true) as $item)
                        <x-content-art :image="$item->cover" :title="$item->name" />
                    @endforeach
                </div>
            </flux:accordion.content>
        </flux:accordion.item>
    @endif
</flux:accordion>