<x-guest-layout>
    <x-slot name="header">Cool Photos</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 space-y-4 mt-4 mb-4">
        @php $photos = App\Models\Photo::paginate(4); @endphp

        @foreach ($photos as $photo)
            <flux:card>
                <div class="flex flex-col items-center">
                    <img src="{{ $photo->path }}" alt="{{ $photo->name}}">

                    <div class="my-2 text-center">
                        <span>{{ $photo->name }} - {{ $photo->captured_at->format('F d, Y') }}</span>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>

    {{ $photos->links() }}
</x-guest-layout>