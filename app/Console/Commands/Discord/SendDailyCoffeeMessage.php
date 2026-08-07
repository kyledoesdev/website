<?php

namespace App\Console\Commands\Discord;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendDailyCoffeeMessage extends Command
{
    protected $signature = 'royal-tea:send-daily-coffee';

    protected $description = 'Send the daily coffee message to Discord';

    /**
     * @var array<int, string>
     */
    private const array DRINKS = [
        'Espresso',
        'Americano',
        'Latte',
        'Cappuccino',
        'Flat White',
        'Cortado',
        'Macchiato',
        'Caramel Macchiato',
        'Mocha',
        'Affogato',
        'Cold Brew',
        'Nitro Cold Brew',
        'Iced Latte',
        'Frappé',
        'French Press',
        'Turkish Coffee',
        'Vietnamese Iced Coffee',
        'Irish Coffee',
        'Drip Coffee',
        'Matcha Latte',
        'Earl Grey Tea',
        'Jasmine Tea',
        'Hōjicha',
        'Hot Chocolate',
        'Pumpkin Spice Latte',
        'Charlie Drink',
        'Espresso Martini',
        'Mimosa',
        'Bloody Mary',
    ];

    public function handle(): int
    {
        $drink = $this->getRandomDrink();

        $response = Http::post(config('services.discord.royalty.beans.webhook_url'), [
            'content' => "Your daily drink is here! Scroll up for your {$drink} - get to sippin!",
        ]);

        if ($response->failed()) {
            $this->error("Failed to send the daily {$drink} to Discord.");

            return self::FAILURE;
        }

        $this->info("Daily coffee message sent! Today's drink: {$drink}.");

        return self::SUCCESS;
    }

    private function getRandomDrink(): string
    {
        return collect(self::DRINKS)->random();
    }
}
