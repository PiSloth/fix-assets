<?php

namespace App\Livewire\FixAsset;

use Livewire\Attributes\Url;
use Livewire\Component;

class TransferAssembly extends Component
{
    #[Url(as: 'id')]
    public $assembly_id;

    public function mount()
    {
        // dd($this->assembly_id);
    }

    public function render()
    {
        return view('livewire.fix-asset.transfer-assembly');
    }
}
