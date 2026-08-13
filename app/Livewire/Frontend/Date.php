<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class Date extends Component
{
    

    public function render()
    {
        
        $date = date("Y-m-d");
        $day = date("l");
        return view('livewire.frontend.date', compact('date', 'day'))
        ->layout('backend.app');
    }
}