@props(['tier'])

@php
    $config = match($tier) {
        'active' => ['label' => 'Active', 'color' => 'green'],
        'close_to_complete' => ['label' => 'Close to Complete', 'color' => 'amber'],
        'in_progress' => ['label' => 'In Progress', 'color' => 'blue'],
        'backlog' => ['label' => 'Backlog', 'color' => 'zinc'],
        'never_played' => ['label' => 'Never Played', 'color' => 'yellow'],
        'completed' => ['label' => 'Completed', 'color' => 'emerald'],
        'excluded' => ['label' => 'Excluded', 'color' => 'zinc'],
        default => ['label' => ucfirst(str_replace('_', ' ', $tier ?? 'Unknown')), 'color' => 'zinc'],
    };
@endphp

<flux:badge size="sm" :color="$config['color']">{{ $config['label'] }}</flux:badge>
