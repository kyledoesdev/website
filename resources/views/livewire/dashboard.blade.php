<div>
    <x-slot name="header">Dashboard</x-slot>

    <flux:card>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('panels') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.pencil-square />
                    <span>All Panels</span>
                </flux:card>
            </a>
            <a href="{{ route('music.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.musical-note />
                    <span>Bands & Music</span>
                </flux:card>
            </a>
            <a href="{{ route('board_games.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.dices />
                    <span>Board Games</span>
                </flux:card>
            </a>
            <a href="{{ route('connections.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.link />
                    <span>Connections</span>
                </flux:card>
            </a>
            <a href="{{ route('education.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.academic-cap />
                    <span>Education</span>
                </flux:card>
            </a>
            <a href="{{ route('movies.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.film />
                    <span>Movies</span>
                </flux:card>
            </a>
            <a href="{{ route('gallery.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.photo />
                    <span>Photo Gallery</span>
                </flux:card>
            </a>
            <a href="{{ route('projects.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.code-bracket />
                    <span>Projects</span>
                </flux:card>
            </a>
            <a href="{{ route('resume.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.document-text />
                    <span>Resumes</span>
                </flux:card>
            </a>
            <a href="{{ route('technology.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.command-line />
                    <span>Technology</span>
                </flux:card>
            </a>
            <a href="{{ route('tv.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.tv />
                    <span>TV Shows</span>
                </flux:card>
            </a>
            <a href="{{ route('video_games.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.gamepad-2 />
                    <span>Video Games</span>
                </flux:card>
            </a>
            <a href="{{ route('work_history.edit') }}">
                <flux:card class="flex space-x-2">
                    <flux:icon.building-office />
                    <span>Work History</span>
                </flux:card>
            </a>
        </div>
    </flux:card>
</div>
