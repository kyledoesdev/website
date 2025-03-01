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
                <div class="overflow-hidden shadow-2xs sm:rounded-lg p-6">
                    <flux:table>
                        @forelse ($this->posts as $key => $data)
                            @php $fm = json_decode($data->frontmatter); @endphp

                            @if ($loop->first)
                                <flux:table.columns>
                                    <flux:table.column sortable :sorted="$sortBy === 'title'" :direction="$sortDirection" wire:click="sort('title')">Title</flux:table.column>
                                    <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection" wire:click="sort('slug')">Slug</flux:table.column>
                                    <flux:table.column sortable :sorted="$sortBy === 'category'" :direction="$sortDirection" wire:click="sort('category')">Category</flux:table.column>
                                    <flux:table.column sortable :sorted="$sortBy === 'views'" :direction="$sortDirection" wire:click="sort('views')">Views</flux:table.column>
                                    <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">Upload Date</flux:table.column>
                                </flux:table.columns>
                            @endif

                            <flux:table.rows>
                                <flux:table.row>
                                    <flux:table.cell>
                                        {{ $fm->title }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $fm->slug }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ $data->category }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ number_format($data->views) }}
                                    </flux:table.cell>

                                    <flux:table.cell>
                                        {{ Carbon\Carbon::parse($data->created_at)->tz('America/New_York')->format('m/d/Y') }}
                                    </flux:table.cell>
                                </flux:table.row>
                            </flux:table.rows>
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