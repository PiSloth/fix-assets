<?php

namespace App\Livewire\ProductSetting;

use App\Models\AccessoriesGroup;
use Livewire\Component;
use Livewire\WithFileUploads;

class AccessoryConfig extends Component
{
    use WithFileUploads;
    public $image, $name, $code;
    public $edit_id;
    public $up_name, $up_code;


    public function create()
    {
        $validated = $this->validate([
            'name' => 'required',
            'code' => 'required|unique:accessories_gorups,code',
            'image' => 'required',
        ]);

        AccessoriesGroup::create($validated);

        $this->dispatch('closeModal', 'newModal');
        $this->reset('name', 'code', 'image');
    }

    public function read($id)
    {
        $query = AccessoriesGroup::find($id);
        $this->up_code = $query->code;
        $this->up_name = $query->name;

        $this->edit_id = $id;
        $this->dispatch('openModal', 'editModal');
    }

    public function update()
    {

        $this->validate([
            'name' => 'required',
            'code' => 'required|unique:accessories_gorups,code,' . $this->edit_id,
        ]);

        AccessoriesGroup::find($this->edit_id)->update([
            'code' => $this->up_code,
            'name' => $this->up_name,
        ]);

        $this->reset('up_name', 'up_code', 'edit_id');
        $this->dispatch('closeModal', 'editModal');
    }

    public function render()
    {
        return view('livewire.product-setting.accessory-config', [
            'accesstory_groups' => AccessoriesGroup::all(),
        ]);
    }
}
