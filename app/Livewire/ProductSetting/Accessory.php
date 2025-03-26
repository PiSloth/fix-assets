<?php

namespace App\Livewire\ProductSetting;

use App\Models\AccessoriesGroup;
use App\Models\Accessory as ModelsAccessory;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

class Accessory extends Component
{
    use WithFileUploads;

    public $image;

    public $name;

    public $code;

    public $edit_id;

    public $up_name;

    public $up_code;

    public $accessories_group_id;

    public function create()
    {
        $validated = $this->validate([
            'name' => 'required',
            'code' => 'required|unique:accessories,code',
            'accessories_group_id' => 'required',
        ]);

        $path = '/images/default.png';

        if ($this->image) {
            $this->validate([
                'image' => 'required|image|max:1024',
            ]);
            $path = $this->image->store('images', 'tempublic');
        }

        ModelsAccessory::create(array_merge([
            'image' => $path,
        ], $validated));

        $this->dispatch('closeModal', 'newModal');
        $this->reset('name', 'code', 'image', 'accessories_group_id');
    }

    public function read($id)
    {
        $query = ModelsAccessory::find($id);
        $this->up_code = $query->code;
        $this->up_name = $query->name;

        $this->edit_id = $id;
        $this->dispatch('openModal', 'editModal');
    }

    public function update()
    {

        $this->validate([
            'name' => 'required',
            'code' => 'required|unique:accessories,code,'.$this->edit_id,
        ]);

        Accessory::find($this->edit_id)->update([
            'accessories_group_id' => $this->accessories_group_id,
            'code' => $this->up_code,
            'name' => $this->up_name,
        ]);

        $this->reset('up_name', 'up_code', 'edit_id', 'accessories_group_id');
        $this->dispatch('closeModal', 'editModal');
    }

    public function cancle_image()
    {
        $this->reset('image');
    }

    #[Title('Accessory')]
    public function render()
    {
        $groups = AccessoriesGroup::all();
        $accessory = ModelsAccessory::all();

        return view('livewire.product-setting.accessory', [
            'accessories' => $accessory,
            'accessories_groups' => $groups,
        ]);
    }
}
