<?php

namespace App\Livewire\Traits;

trait TableHelpers
{
    public string $search = '';

    public string $sortBy = 'id';

    public string $sortDirection = 'desc';

    public int $perPage = 25;

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }
}
