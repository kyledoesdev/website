<x-guest-layout>
    @seo([
        'title' => $frontmatter->title,
        'description' => $frontmatter->excerpt,
        'url' => route('prezet.show', ['slug' => $frontmatter->slug]),
        'image' => $frontmatter->image,
    ])

    {{-- Main Content --}}
    <article>
        <header class="mb-9 space-y-1">
            <p class="font-display text-sm font-medium text-primary-600">
                {{ $frontmatter->category }}
            </p>
            <h1
                class="font-display text-4xl font-medium tracking-tight"
            >
                {{ $frontmatter->title }}
            </h1>
        </header>
        <div
            class="prose-headings:font-display prose prose-gray max-w-none prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline hover:prose-a:border-solid prose-img:rounded-xs dark:prose-invert"
        >
            {!! $body !!}
        </div>
    </article>
</x-guest-layout>
