<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

const BEANS_WEBHOOK = 'https://discord.com/api/webhooks/beans';

beforeEach(function () {
    config()->set('services.discord.royalty.beans.webhook_url', BEANS_WEBHOOK);
});

it('sends the daily drink to the beans webhook', function () {
    Http::fake([BEANS_WEBHOOK => Http::response('', 204)]);

    $this->artisan('royal-tea:send-daily-coffee')->assertSuccessful();

    Http::assertSent(fn (Request $request) => $request->url() === BEANS_WEBHOOK
        && str_contains($request->data()['content'], 'Your daily drink is here!'));
});

it('fails when discord rejects the webhook', function () {
    Http::fake([BEANS_WEBHOOK => Http::response('', 404)]);

    $this->artisan('royal-tea:send-daily-coffee')->assertFailed();
});
