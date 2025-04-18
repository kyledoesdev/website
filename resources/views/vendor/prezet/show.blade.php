<x-guest-layout>
    @seo([
        'title' => $document->frontmatter->title,
        'description' => $document->frontmatter->excerpt,
        'url' => route('prezet.show', ['slug' => $document->slug]),
        'keywords' => implode(', ', $document->frontmatter->tags),
    ])

    {{-- Main Content --}}
    <flux:card>
        <article>
            <header class="mb-9 space-y-1">
                <p class="font-display text-sm font-medium text-primary-600">
                    {{ $document->frontmatter->category }}
                </p>
                <h1
                    class="font-display text-4xl font-medium tracking-tight mb-2"
                >
                    {{ $document->frontmatter->title }}
                </h1>
                <flux:badge icon="eye" size="sm">
                    {{ number_format($views) }}
                </flux:badge>
            </header>
            <div
                class="prose-headings:font-display prose prose-gray max-w-none prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline hover:prose-a:border-solid prose-img:rounded-xs dark:prose-invert"
            >
                {!! $body !!}
            </div>
        </article>
    </flux:card>
</x-guest-layout>
