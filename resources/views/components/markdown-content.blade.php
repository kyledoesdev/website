@props([
    'content',
    'size'
])

@php
    $size ??= 'text-base'
@endphp

<article class="
    prose prose-img:rounded-xl
    prose-headings:underline
    prose-a:text-blue-600
    dark:prose-invert
    dark:prose-a:text-blue-300 max-w-full {{ $size }}
">
    {!! Str::of($content)->markdown() !!}
</article>