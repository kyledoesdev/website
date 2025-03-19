<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <flux:card>
        <flux:tab.group>
            <div style="overflow-x: auto;">
                <flux:tabs>
                    <flux:tab name="career" icon="briefcase">Career</flux:tab>
                    <flux:tab name="fun" icon="gamepad-2">Fun</flux:tab>
                    <flux:tab name="settings" icon="cog-6-tooth">Settings</flux:tab>
                </flux:tabs>
            </div>

            {{-- Career --}}
            <flux:tab.panel name="career">
                <flux:tab.group>
                    <div style="overflow-x: auto;">
                        <flux:tabs>
                            <flux:tab name="career-panels" icon="pencil-square">Panels</flux:tab>
                            <flux:tab name="blog" icon="arrow-up-tray">Blog</flux:tab>
                            <flux:tab name="technologies" icon="command-line">Technologies</flux:tab>
                            <flux:tab name="resume" icon="document-text">Resume</flux:tab>
                        </flux:tabs>
                    </div>

                    <flux:tab.panel name="career-panels">
                        <livewire:panels :type="'career'" />
                    </flux:tab.panel>
                    <flux:tab.panel name="blog">
                        <livewire:blog />
                    </flux:tab.panel>
                    <flux:tab.panel name="technologies">
                        <livewire:technologies />
                    </flux:tab.panel>
                    <flux:tab.panel name="resume">
                        <livewire:resume />
                    </flux:tab.panel>
                </flux:tab.group>
            </flux:tab.panel>

            {{-- Fun --}}
            <flux:tab.panel name="fun">
                <flux:tab.group>
                    <div style="overflow-x: auto;">
                        <flux:tabs>
                            <flux:tab name="fun_panels" icon="pencil-square">Panels</flux:tab>
                            <flux:tab name="movies" icon="dices">Board Games</flux:tab>
                            <flux:tab name="movies" icon="film">Movies</flux:tab>
                            <flux:tab name="music" icon="musical-note">Music</flux:tab>
                            <flux:tab name="photos" icon="photo">Photos</flux:tab>
                            <flux:tab name="tv" icon="tv">Tv</flux:tab>
                            <flux:tab name="games" icon="gamepad-2">Video Games</flux:tab>
                        </flux:tabs>
                    </div>

                    <flux:tab.panel name="fun_panels">
                        <livewire:panels :type="'fun'" />
                    </flux:tab.panel>
                    <flux:tab.panel name="games"></flux:tab.panel>
                    <flux:tab.panel name="music">Music</flux:tab.panel>
                    <flux:tab.panel name="movies">Movies</flux:tab.panel>
                    <flux:tab.panel name="tv">TV</flux:tab.panel>
                    <flux:tab.panel name="photos">
                        <livewire:photos.uploader />
                    </flux:tab.panel>
                </flux:tab.group>
            </flux:tab.panel>

            {{-- Settings --}}
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
