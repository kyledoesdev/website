@props([
    'content',
    'size',
    'scroll'
])

@php
    $size ??= 'text-base';
    $scroll = isset($scroll) ? 'h-[40vh] overflow-y-auto' : '';
@endphp

<article class="
    prose prose-img:rounded-xl
    prose-headings:underline
    prose-a:text-blue-600
    dark:prose-invert
    dark:prose-a:text-blue-300 max-w-full {{ $size }} {{ $scroll }}
">
    {!! Str::of($content)->markdown() !!}
</article>