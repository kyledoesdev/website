<div>
    <x-slot name="header">Blog Posts</x-slot>

    <flux:card>
        <div class="flex justify-between">
            <div>
                <flux:input type="file" wire:model="file" label="Upload Blog Post" />
            </div>
        </div>
        
        <div class="my-4">
            <flux:button variant="primary" size="xs" wire:click="store" icon="arrow-up-tray">Upload</flux:button>
        </div>

        <flux:separator />
    
        <div class="py-2">
            <div class="overflow-hidden shadow-2xs sm:rounded-lg">
                {{-- todo - find a fix for pagination --}}
                <flux:table>
                    @forelse ($this->posts as $post)
                        @php $data = json_decode($post->frontmatter); @endphp

                        @if ($loop->first)
                            <flux:table.columns>
                                <flux:table.column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection" wire:click="sort('title')">Title</flux:table.column>
                                <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection" wire:click="sort('slug')">Slug</flux:table.column>
                                <flux:table.column sortable :sorted="$sortBy === 'category'" :direction="$sortDirection" wire:click="sort('category')">Category</flux:table.column>
                                <flux:table.column sortable :sorted="$sortBy === 'views'" :direction="$sortDirection" wire:click="sort('views')">Views</flux:table.column>
                                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Upload Date</flux:table.column>
                                <flux:table.column>Actions</flux:table.column>
                            </flux:table.columns>
                        @endif

                        <flux:table.rows>
                            <flux:table.row>
                                <flux:table.cell>
                                    {{ $data->title }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    {{ $data->slug }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    {{ $post->category }}
                                </flux:table.cell>

                                <flux:table.cell>
                                     <a href="{{ route('blog.post_views', ['post' => $post->id]) }}">
                                        <flux:badge>
                                            {{ number_format($post->views) }}
                                        </flux:badge>
                                    </a>
                                </flux:table.cell>

                                <flux:table.cell>
                                    {{ Carbon\Carbon::parse($post->created_at)->tz('America/New_York')->format('m/d/Y') }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    <flux:button
                                        variant="primary"
                                        size="sm"
                                        icon="eye"
                                        href="{{ route('prezet.show', ['slug' => $data->slug]) }}"
                                        target="_blank"
                                    />
                                    <flux:button
                                        variant="danger"
                                        size="sm"
                                        icon="trash"
                                        wire:click="destroy({{ $post->id }})"
                                        wire:confirm="Are you sure you want to delete this blog post"
                                    />
                                </flux:table.cell>
                            </flux:table.row>
                        </flux:table.rows>
                    @empty
                    @endforelse
                </flux:table>
            </div>
        </div>
    </flux:card>
</div>