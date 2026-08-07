<?php

namespace App\Enums;

/**
 * WMO weather interpretation codes as returned by the Open-Meteo forecast API.
 *
 * @see https://open-meteo.com/en/docs
 */
enum WeatherCondition: int
{
    case UNKNOWN = -1;
    case CLEAR_SKY = 0;
    case MAINLY_CLEAR = 1;
    case PARTLY_CLOUDY = 2;
    case OVERCAST = 3;
    case FOG = 45;
    case RIME_FOG = 48;
    case LIGHT_DRIZZLE = 51;
    case MODERATE_DRIZZLE = 53;
    case DENSE_DRIZZLE = 55;
    case LIGHT_FREEZING_DRIZZLE = 56;
    case DENSE_FREEZING_DRIZZLE = 57;
    case SLIGHT_RAIN = 61;
    case MODERATE_RAIN = 63;
    case HEAVY_RAIN = 65;
    case LIGHT_FREEZING_RAIN = 66;
    case HEAVY_FREEZING_RAIN = 67;
    case SLIGHT_SNOW = 71;
    case MODERATE_SNOW = 73;
    case HEAVY_SNOW = 75;
    case SNOW_GRAINS = 77;
    case SLIGHT_RAIN_SHOWERS = 80;
    case MODERATE_RAIN_SHOWERS = 81;
    case VIOLENT_RAIN_SHOWERS = 82;
    case SLIGHT_SNOW_SHOWERS = 85;
    case HEAVY_SNOW_SHOWERS = 86;
    case THUNDERSTORM = 95;
    case THUNDERSTORM_WITH_SLIGHT_HAIL = 96;
    case THUNDERSTORM_WITH_HEAVY_HAIL = 99;

    public static function fromWmoCode(?int $code): self
    {
        return self::tryFrom($code ?? self::UNKNOWN->value) ?? self::UNKNOWN;
    }

    public function label(): string
    {
        return match ($this) {
            self::UNKNOWN => 'Unknown',
            self::CLEAR_SKY => 'Clear Sky',
            self::MAINLY_CLEAR => 'Mainly Clear',
            self::PARTLY_CLOUDY => 'Partly Cloudy',
            self::OVERCAST => 'Overcast',
            self::FOG => 'Fog',
            self::RIME_FOG => 'Freezing Fog',
            self::LIGHT_DRIZZLE => 'Light Drizzle',
            self::MODERATE_DRIZZLE => 'Drizzle',
            self::DENSE_DRIZZLE => 'Heavy Drizzle',
            self::LIGHT_FREEZING_DRIZZLE => 'Light Freezing Drizzle',
            self::DENSE_FREEZING_DRIZZLE => 'Freezing Drizzle',
            self::SLIGHT_RAIN => 'Light Rain',
            self::MODERATE_RAIN => 'Rain',
            self::HEAVY_RAIN => 'Heavy Rain',
            self::LIGHT_FREEZING_RAIN => 'Light Freezing Rain',
            self::HEAVY_FREEZING_RAIN => 'Freezing Rain',
            self::SLIGHT_SNOW => 'Light Snow',
            self::MODERATE_SNOW => 'Snow',
            self::HEAVY_SNOW => 'Heavy Snow',
            self::SNOW_GRAINS => 'Snow Grains',
            self::SLIGHT_RAIN_SHOWERS => 'Light Showers',
            self::MODERATE_RAIN_SHOWERS => 'Showers',
            self::VIOLENT_RAIN_SHOWERS => 'Violent Showers',
            self::SLIGHT_SNOW_SHOWERS => 'Light Snow Showers',
            self::HEAVY_SNOW_SHOWERS => 'Heavy Snow Showers',
            self::THUNDERSTORM => 'Thunderstorm',
            self::THUNDERSTORM_WITH_SLIGHT_HAIL => 'Thunderstorm With Hail',
            self::THUNDERSTORM_WITH_HEAVY_HAIL => 'Thunderstorm With Heavy Hail',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::UNKNOWN => '❔',
            self::CLEAR_SKY, self::MAINLY_CLEAR => '☀️',
            self::PARTLY_CLOUDY => '⛅',
            self::OVERCAST => '☁️',
            self::FOG, self::RIME_FOG => '🌫️',
            self::LIGHT_DRIZZLE, self::MODERATE_DRIZZLE, self::DENSE_DRIZZLE => '🌦️',
            self::LIGHT_FREEZING_DRIZZLE, self::DENSE_FREEZING_DRIZZLE,
            self::LIGHT_FREEZING_RAIN, self::HEAVY_FREEZING_RAIN => '🧊',
            self::SLIGHT_RAIN, self::MODERATE_RAIN, self::SLIGHT_RAIN_SHOWERS,
            self::MODERATE_RAIN_SHOWERS => '🌧️',
            self::HEAVY_RAIN, self::VIOLENT_RAIN_SHOWERS => '⛈️',
            self::SLIGHT_SNOW, self::MODERATE_SNOW, self::HEAVY_SNOW,
            self::SNOW_GRAINS, self::SLIGHT_SNOW_SHOWERS, self::HEAVY_SNOW_SHOWERS => '❄️',
            self::THUNDERSTORM, self::THUNDERSTORM_WITH_SLIGHT_HAIL,
            self::THUNDERSTORM_WITH_HEAVY_HAIL => '🌩️',
        };
    }

    /**
     * Decimal colour used to tint the Discord embed sidebar.
     */
    public function color(): int
    {
        return match ($this) {
            self::CLEAR_SKY, self::MAINLY_CLEAR => 0xFDB813,
            self::PARTLY_CLOUDY => 0x89CFF0,
            self::OVERCAST, self::FOG, self::RIME_FOG, self::UNKNOWN => 0x8E9AAF,
            self::THUNDERSTORM, self::THUNDERSTORM_WITH_SLIGHT_HAIL,
            self::THUNDERSTORM_WITH_HEAVY_HAIL, self::HEAVY_RAIN,
            self::VIOLENT_RAIN_SHOWERS => 0x5B4B8A,
            self::SLIGHT_SNOW, self::MODERATE_SNOW, self::HEAVY_SNOW, self::SNOW_GRAINS,
            self::SLIGHT_SNOW_SHOWERS, self::HEAVY_SNOW_SHOWERS,
            self::LIGHT_FREEZING_DRIZZLE, self::DENSE_FREEZING_DRIZZLE,
            self::LIGHT_FREEZING_RAIN, self::HEAVY_FREEZING_RAIN => 0xE3F2FD,
            default => 0x4A90D9,
        };
    }
}
