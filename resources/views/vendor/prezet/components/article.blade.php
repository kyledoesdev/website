<article>
    <flux:card
        class="space-y-2 xl:grid xl:grid-cols-4 xl:items-baseline xl:space-y-0"
    >
        <dl>
            <dt class="sr-only">Published on</dt>
            <dd class="text-base font-medium leading-6">
                <time datetime="{{ $article->createdAt->toIso8601String() }}">
                    {{ $article->createdAt->format('F j, Y') }}
                </time>
            </dd>
        </dl>
        <div class="space-y-5 xl:col-span-3">
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold leading-8 tracking-tight">
                        <a
                            href="{{ route('prezet.show', $article->slug) }}"
                        >
                            {{ $article->title }}
                        </a>
                    </h2>
                    <div class="flex flex-wrap">
                        <a
                            class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600"
                            href="{{ route('prezet.index', ['category' => $article->category]) }}"
                        >
                            {{ $article->category }}
                        </a>
                        @foreach ($article->tags as $tag)
                            <a
                                class="mr-3 text-sm font-medium uppercase text-primary-500 hover:text-primary-600"
                                href="{{ route('prezet.index', ['tag' => $tag]) }}"
                            >
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="prose dark:prose-invert max-w-none">
                    {{ $article->excerpt }}
                </div>
            </div>
            <div class="text-base font-medium leading-6">
                <a
                    class="text-primary-500 hover:text-primary-600"
                    aria-label='Read more: "Release of Tailwind Nextjs Starter Blog v2.0"'
                    href="{{ route('prezet.show', $article->slug) }}"
                >
                    Read more →
                </a>
            </div>
            <div>
                <flux:badge icon="eye">{{ number_format($article->views) }}</flux:badge>
            </div>
        </div>
    </flux:card>
</article>
