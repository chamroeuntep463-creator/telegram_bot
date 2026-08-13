<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.frontend.dashboard')->layout('backend.app');
    }
}
