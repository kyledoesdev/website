<?php

namespace App\Livewire\Forms;

use App\Models\WeatherReportCity;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Form;

class WeatherReportCityForm extends Form
{
    public string $city = '';

    public string $state = '';

    public ?float $latitude = null;

    public ?float $longitude = null;

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'city' => [
                'required',
                'string',
                'max:255',
                Rule::unique('weather_report_cities', 'city')->where('state', $this->state),
            ],
            'state' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * @param  array{city: string, state: string, latitude: float, longitude: float}  $city
     */
    public function fillFromSearch(array $city): void
    {
        $this->city = $city['city'];
        $this->state = $city['state'];
        $this->latitude = $city['latitude'];
        $this->longitude = $city['longitude'];

        $this->resetValidation();
    }

    public function name(): string
    {
        return "{$this->city}, {$this->state}";
    }

    public function store(): void
    {
        $this->validate();

        WeatherReportCity::create([
            'city' => $this->city,
            'state' => $this->state,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        $this->reset();

        Flux::modal('create-weather-report-city')->close();

        Flux::toast(variant: 'success', text: 'City Added!', duration: 3000);
    }
}
