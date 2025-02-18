<div>
    <section class="px-6">
        <div class="flex justify-between">
            <div>
                <flux:input type="file" wire:model="file" label="Upload Blog Post" />
            </div>
        </div>
        
        <div class="my-4">
            <flux:button variant="primary" size="xs" wire:click="store" icon="arrow-up-tray">Upload</flux:button>
        </div>

        <flux:separator />
    </section>

    <section>
        <div class="py-2">
            <div class="max-w-7xl mx-auto">
                <div class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <flux:table>
                        @forelse ($this->posts as $key => $data)
                            @php $fm = json_decode($data->frontmatter); @endphp

                            @if ($loop->first)
                                <flux:columns>
                                    <flux:column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection" wire:click="sort('title')">Title</flux:column>
                                    <flux:column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection" wire:click="sort('slug')">Slug</flux:column>
                                    <flux:column sortable :sorted="$sortBy === 'category'" :direction="$sortDirection" wire:click="sort('category')">Category</flux:column>
                                    <flux:column sortable :sorted="$sortBy === 'views'" :direction="$sortDirection" wire:click="sort('views')">Views</flux:column>
                                    <flux:column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Upload Date</flux:column>
                                </flux:columns>
                            @endif

                            <flux:rows>
                                <flux:row>
                                    <flux:cell>
                                        {{ $fm->title }}
                                    </flux:cell>

                                    <flux:cell>
                                        {{ $fm->slug }}
                                    </flux:cell>

                                    <flux:cell>
                                        {{ $data->category }}
                                    </flux:cell>

                                    <flux:cell>
                                        {{ number_format($data->views) }}
                                    </flux:cell>

                                    <flux:cell>
                                        {{ Carbon\Carbon::parse($data->created_at)->tz('America/New_York')->format('m/d/Y') }}
                                    </flux:cell>
                                </flux:row>
                            </flux:rows>
                        @empty
                            <flux:card>
                                <div class="flex justify-center my-4">
                                    <flux:badge>No Blog Posts found.</flux:badge>
                                </div>
                            </flux:card>
                        @endforelse
                    </flux:table>
                </div>
            </div>
        </div>
    </section>
</div>