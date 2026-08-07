<?php

namespace App\Livewire\Pages\WeatherReport\Tables;

use App\Models\WeatherReportCity;
use Flux\Flux;
use Livewire\Component;

class Row extends Component
{
    public WeatherReportCity $city;

    public function render()
    {
        return view('livewire.pages.weather-report.partials.row');
    }

    public function destroy(): void
    {
        $this->city->delete();

        Flux::toast(variant: 'success', text: 'City Removed!', duration: 3000);

        $this->dispatch('weather-report-city-deleted');
    }
}
