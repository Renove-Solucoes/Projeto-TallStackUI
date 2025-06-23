<?php

namespace App\Livewire\Enderecos;

use App\Livewire\Traits\Alert;
use App\Models\Endereco;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use Alert;

    public ?Endereco $endereco;


    public bool $modal = false;


    #[On('load::endereco')]
    public function load(Endereco $endereco): void
    {
        $this->endereco = $endereco;
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function render()
    {
        return view('livewire.enderecos.update');
    }
}
