<?php

namespace App\Http\Controllers;

use App\Enums\ConnectionType;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class ConnectionController extends Controller
{
    public function connect(Request $request, string $type)
    {
        session()->put('current_connection_type_id', $this->getConnectionTypeId($type));
        session()->put('current_connection_type', $type);

        return Socialite::driver($type)->redirect();
    }

    public function processConnection(Request $request)
    {
        $user = Socialite::driver(session()->get('current_connection_type'))->stateless()->user();

        auth()->user()->connections()->updateOrCreate(['type_id' => session()->get('current_connection_type_id')], [
            'type_id' => session()->get('current_connection_type_id'),
            'external_id' => $user->id,
            'token' => $user->token,
            'refresh_token' => $user->refreshToken,
        ]);

        session()->forget('current_connection_type_id');
        session()->forget('current_connection_type');

        return redirect(route('dashboard'));
    }

    private function getConnectionTypeId(string $type)
    {
        dd(ConnectionType::TWITCH->slug());

        return match ($type) {
            'twitch' => ConnectionType::TWITCH->slug(),
            'spotify' => ConnectionType::SPOTIFY->slug()
        };
    }
}
