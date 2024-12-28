<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('welcome', [
            'bio' => Panel::where('name', 'bio')->first(),
        ]);
    }
}
