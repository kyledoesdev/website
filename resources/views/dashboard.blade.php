<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <flux:card>
        <flux:tab.group>
            <div class="md:flex md:justify-center" style="overflow-x: auto;">
                <flux:tabs variant="pills">
                    <flux:tab name="panels" icon="pencil-square">Panels</flux:tab>
                    <flux:tab name="blog" icon="arrow-up-tray">Blog</flux:tab>
                    <flux:tab name="technologies" icon="command-line">Technologies</flux:tab>
                    <flux:tab name="photos" icon="photo">Photos</flux:tab>
                    <flux:tab name="settings" icon="cog-6-tooth">Settings</flux:tab>
                </flux:tabs>
            </div>

            <flux:separator class="my-2" />

            <flux:tab.panel name="panels">
                <livewire:panels />
            </flux:tab.panel>

            <flux:tab.panel name="blog">
                Blog
            </flux:tab.panel>

            <flux:tab.panel name="technologies">
                <livewire:technologies />
            </flux:tab.panel>

            <flux:tab.panel name="photos">
                <livewire:photo-upload />
            </flux:tab.panel>

            <flux:tab.panel name="settings">
                <livewire:profile.update-profile-information-form />
                <flux:separator />
                <livewire:profile.update-password-form />
                <flux:separator />
                <livewire:profile.delete-user-form />
            </flux:tab.panel>
        </flux:tab.group>
    </flux:card>
</x-app-layout>
