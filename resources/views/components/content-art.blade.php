@props([
    'image',
    'title',
    'size'
])

<img
    class="my-2 w-[20vw] md:w-[142px] h-auto"
    src="{{ $image }}"
    alt="{{ $title }}"
/>