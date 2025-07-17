<div>
    <x-slot name="header">Blog Posts</x-slot>

    <flux:card>
        <div class="space-y-4">
            <div class="flex justify-between">
                <div class="flex-1 space-y-4">
                    <flux:input
                        type="file"
                        wire:model="file"
                        label="Upload Blog Post"
                        accept=".md"
                        size="sm"
                    />
                    
                    <flux:input
                        type="file"
                        wire:model="images"
                        label="Upload Images (Optional)"
                        multiple
                        accept="image/*"
                        size="sm"
                    />
                </div>
            </div>
            
            @if ($images)
                <div class="mt-2">
                    <flux:badge variant="lime" size="sm">
                        {{ count($images) }} image(s) selected
                    </flux:badge>
                </div>
            @endif
            
            <div class="flex gap-2 my-4">
                <flux:button variant="primary" size="xs" wire:click="store" icon="arrow-up-tray">
                    Upload Blog Post
                </flux:button>
                
                @if ($file || $images)
                    <flux:button variant="ghost" size="xs" wire:click="clearUploads" icon="x-mark">
                        Clear
                    </flux:button>
                @endif
            </div>

            @error('file') 
                <flux:error>{{ $message }}</flux:error>
            @enderror
            
            @error('images.*') 
                <flux:error>{{ $message }}</flux:error>
            @enderror
        </div>

        <flux:separator class="my-4" />
    
        <flux:card>
            <div class="overflow-hidden shadow-2xs sm:rounded-lg">
                <flux:table :paginate="$this->posts">
                    @forelse ($this->posts as $post)
                        @php $data = $post->frontmatter; @endphp

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

                        <flux:table.row :key="$post->getKey()">
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
                    @empty
                        <flux:card>
                            <div class="flex justify-center my-4">
                                <flux:badge>No Posts found.</flux:badge>
                            </div>
                        </flux:card>
                    @endforelse
                </flux:table>
            </div>
        </flux:card>
    </flux:card>
</div>