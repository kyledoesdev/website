<div>
    <x-slot name="header">Manage External Connections</x-slot>

    @php
        $spotify = auth()->user()->connections->firstWhere('type_id', App\Models\ConnectionType::SPOTIFY);
        $twitch = auth()->user()->connections->firstWhere('type_id', App\Models\ConnectionType::TWITCH);
    @endphp

    <flux:card class="flex flex-col space-y-2">
        <div>
            @if (is_null($spotify))
                <flux:button variant="outline" icon="audio-waveform" href="{{ route('connect', ['type' => 'spotify']) }}">
                    Connect Spotify
                </flux:button>
            @else
                <flux:badge color="lime">
                    Spotify Connected: {{ $spotify->created_at }}
                </flux:badge>
            @endif
        </div>
        <div>
            @if (is_null($twitch))
                <flux:button variant="outline" icon="audio-waveform" href="{{ route('connect', ['type' => 'twitch']) }}">
                    Connect Twitch
                </flux:button>
            @else
                <flux:badge color="purple">
                    Twitch Connected: {{ $twitch->created_at }}
                </flux:badge>
            @endif
        </div>
    </flux:card>
</div>
