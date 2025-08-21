<x-guest-layout>
    @seo([
        'title' => $document->frontmatter->title,
        'description' => $document->frontmatter->excerpt,
        'url' => route('prezet.show', ['slug' => $document->slug]),
        'keywords' => implode(', ', $document->frontmatter->tags),
    ])
    
    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-8 md:py-2 sm:py-6">
        <flux:card class="overflow-hidden">
            <article class="overflow-x-auto">
                <header class="mb-6 sm:mb-9 space-y-2 sm:space-y-1">
                    <p class="font-display text-xs sm:text-sm font-medium text-primary-600">
                        {{ $document->frontmatter->category }}
                    </p>
                    <h1 class="font-display text-2xl sm:text-3xl lg:text-4xl font-medium tracking-tight mb-2 leading-tight">
                        {{ $document->frontmatter->title }}
                    </h1>
                    <flux:badge icon="eye" size="sm">
                        {{ number_format($views) }}
                    </flux:badge>
                </header>
                <div class="prose-headings:font-display prose prose-sm sm:prose-base prose-gray max-w-none prose-headings:text-xl prose-headings:sm:text-2xl prose-headings:lg:text-3xl prose-headings:leading-tight prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline hover:prose-a:border-solid prose-img:rounded-xs prose-img:max-w-full prose-img:h-auto prose-table:text-sm prose-pre:text-sm prose-pre:overflow-x-auto dark:prose-invert">
                    {!! $body !!}
                </div>
            </article>
        </flux:card>
    </div>
</x-guest-layout>