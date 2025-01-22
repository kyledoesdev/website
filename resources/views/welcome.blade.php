<x-guest-layout>
    <x-slot name="header">Hi, I'm Kyle 👋</x-slot>

    <div class="mt-4">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-auto md:mr-4 mb-4 md:mb-0">
                <img class="rounded-lg border-8 border-zinc-800 mx-auto md:mx-0 max-w-64" src="{{ asset('me.jfif') }}">

                <div class="my-4 md:mt-4 items-center text-center hidden md:block">
                    <span class="text-xs italic">
                        Do it right the first time · Less is more · The cake is a lie
                    </span>
                </div>
            </div>

            <flux:separator vertical class="hidden md:block" />

            <div class="mx-4">
                <x-markdown-content :content="$bio->content" />
            </div>
        </div>
    </div>
</x-guest-layout>