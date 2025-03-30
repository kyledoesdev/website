@props([
    'collection',
    'title'
])

<flux:accordion.item>
    <flux:accordion.heading>
        {{ $title }}
    </flux:accordion.heading>
    <flux:accordion.content>
        <div class="flex" style="overflow-y: auto; max-height: 500px;">
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-9 gap-2 md:gap-4 space-x-4 space-y-1">
                @foreach ($collection as $item)
                    <x-content-art :image="$item->cover" :title="$item->name" />
                @endforeach
            </div>
        </div>

        <flux:pagination :paginator="$collection" />
    </flux:accordion.content>
</flux:accordion.item>