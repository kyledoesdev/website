<?php

namespace App\Livewire;

use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        return view('navigation', [
            'resume' => Asset::where('type_id', Asset::RESUME)->first()?->slug
        ]);
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/', navigate: true);
    }
}
