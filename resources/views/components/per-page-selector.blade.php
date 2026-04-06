@props([
    'options' => [10, 25, 50, 100],
    'model' => 'perPage',
])

<flux:select size="sm" wire:model.live="{{ $model }}" class="w-20">
    @foreach ($options as $option)
        <flux:select.option :value="$option">{{ $option }}</flux:select.option>
    @endforeach
</flux:select>
