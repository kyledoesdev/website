<div>
    <x-slot name="header">Video Games</x-slot>

    <div class="space-y-4 mt-4">
        <flux:card>
            <x-markdown-content :content="$panel" :scroll="true" />
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="xl">
                Video Game Catalog
            </flux:heading>

            <flux:separator />

            <flux:accordion transition>
                <x-media-accordian-item
                    :collection="$favorites"
                    :title="'My Favorites'"
                    :pageName="'Favorites'"
                />
                <x-media-accordian-item
                    :collection="$current"
                    :title="'Currently Playing'"
                    :pageName="'Active'"
                />
                <x-media-accordian-item
                    :collection="$backlog"
                    :title="'In Backlog'"
                    :pageName="'Backlog'"
                />
                <x-media-accordian-item
                    :collection="$playedBefore"
                    :title="'Played Before'"
                    :pageName="'PlayedBefore'"
                />
                <x-media-accordian-item
                    :collection="$completed"
                    :title="'100%-ed'"
                    :pageName="'Completed'"
                    :description="'Games where I have collected 100% of the achievements or collectables.'"
                />
            </flux:accordion>
        </flux:card>
    </div>
</div>
