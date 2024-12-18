<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('welcome', [
            'bio' => Panel::where('name', 'bio')->first(),
        ]);
    }
}
