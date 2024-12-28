<x-guest-layout>
    <x-slot name="header">Hi, I'm Kyle 👋</x-slot>

    <div class="mt-4">
        <flux:card class="dark:bg-zinc-700">
            <div class="flex">
                <div class="hidden md:block mr-4">
                    <img class="rounded-xl max-w-32" src="{{ asset('me.jfif') }}" alt="Kyle Evangelisto Headshot">
                    <flux:button variant="primary" size="xs" class="mt-2">I'm feeling lucky!</flux:button>
                </div>

                <flux:separator vertical class="hidden md:block" />

                <div class="mx-4">
                    <x-markdown-content :content="$bio->content" />
                </div>
            </div>
        </flux:card>

        <div class="flex flex-col mt-4 mb-4 md:mt-8 lg:mt-12 items-center text-center">
            <div class="mb-2 w-full">
                <span class="text-xs italic">
                    Do it right the first time · Less is more · The cake is a lie
                </span>
            </div>
        </div>                                                
    </div>
</x-guest-layout>