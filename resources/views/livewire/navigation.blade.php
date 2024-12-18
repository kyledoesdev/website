<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<flux:header container>
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" href="{{ route('welcome') }}" :current="request()->is('/')">
            Home
        </flux:navbar.item>

        @auth
            <flux:navbar.item icon="adjustments-horizontal" href="{{ route('dashboard') }}" :current="request()->is('dashboard')">
                Dashboard
            </flux:navbar.item>
        @endauth

        <flux:navbar.item icon="pencil-square" href="{{ route('prezet.index') }}" :current="request()->is('blog', 'blog/*')">
            Blog
        </flux:navbar.item>
        <flux:dropdown>
            <flux:navbar.item
                icon="fire"
                icon-trailing="chevron-down"
                :current="request()->is('work_history', 'education', 'technology', 'projects')"
            >
                Cool Stuff
            </flux:navbar.item>

            <flux:navmenu>
                <flux:navmenu.item icon="building-office" href="{{ route('work_history') }}">
                    Work History
                </flux:navmenu.item>
                <flux:navmenu.item icon="academic-cap" href="{{ route('education') }}">
                    Education
                </flux:navmenu.item>
                <flux:navmenu.item icon="code-bracket" href="{{ route('projects') }}">
                    Projects
                </flux:navmenu.item>
                <flux:navmenu.item icon="command-line" href="{{ route('technologies') }}">
                    Technology
                </flux:navmenu.item>
                <flux:navmenu.item icon="photo" href="#">
                    Photo Gallery
                </flux:navmenu.item>
            </flux:navmenu>
        </flux:dropdown>
    </flux:navbar>

    <flux:spacer />

    <flux:button x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />

    @auth
        <flux:dropdown position="top" align="start">
            <flux:button class="mx-2" size="sm" icon-trailing="chevron-down">{{ auth()->user()->name }}</flux:button>

            <flux:menu>
                <flux:menu.item icon="arrow-right-start-on-rectangle" wire:click="logout">
                    Logout
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @else
        <flux:button size="sm" class="mx-1" href="{{ route('login') }}" icon-trailing="arrow-up-right">Login</flux:button>
    @endauth
</flux:header>