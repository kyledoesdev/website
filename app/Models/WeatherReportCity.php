<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;

class WeatherReportCity extends Model
{
    protected $fillable = [
        'city',
        'state',
        'latitude',
        'longitude',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('state')->orderBy('city'));
    }

    public function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function getNameAttribute(): string
    {
        return "{$this->city}, {$this->state}";
    }

    /**
     * The shape the Open-Meteo forecast action expects.
     *
     * @return array{name: string, latitude: float, longitude: float}
     */
    public function toForecastLocation(): array
    {
        return [
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
