<?php

namespace App\Http\Controllers;

use App\Enums\ConnectionType;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class ConnectionController extends Controller
{
    public function connect(Request $request, string $type)
    {
        $connectionType = ConnectionType::from($type);

        session()->put('current_connection_type', $connectionType->value);

        return Socialite::driver($connectionType->value)->redirect();
    }

    public function processConnection(Request $request)
    {
        $type = session()->get('current_connection_type');

        $user = Socialite::driver($type)->stateless()->user();

        auth()->user()->connections()->updateOrCreate(['type' => $type], [
            'type' => $type,
            'external_id' => $user->id,
            'token' => $user->token,
            'refresh_token' => $user->refreshToken,
        ]);

        session()->forget('current_connection_type');

        return redirect(route('dashboard'));
    }
}
