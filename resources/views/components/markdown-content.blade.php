@props([
    'content',
])

<article class="
    prose prose-img:rounded-xl
    prose-headings:underline
    prose-a:text-blue-600
    dark:prose-invert
    dark:prose-a:text-blue-300 max-w-full
">
    {!! Str::of($content)->markdown() !!}
</article>