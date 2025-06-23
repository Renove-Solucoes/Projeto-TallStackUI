<?php

namespace App\Livewire\Tags;

use Livewire\Component;

class Create extends Component
{

    public bool $modal = false;
    
    public function render()
    {
        return view('livewire.tags.create');
    }
}
