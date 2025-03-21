<?php

namespace App\Livewire\ProductSetting;

use App\Models\AccessoriesGroup;
use Livewire\Component;
use Livewire\WithFileUploads;

class AccessoryConfig extends Component
{
    use WithFileUploads;

    public $image;

    public $name;

    public $code;

    public $edit_id;

    public $up_name;

    public $up_code;

    public function create()
    {
        $validated = $this->validate([
            'name' => 'required',
            'code' => 'required|unique:accessories_groups,code',
        ]);

        $path = '/images/default.png';

        if ($this->image) {
            $this->validate([
                'image' => 'required|image|max:1024',
            ]);
            $path = $this->image->store('images', 'tempublic');
        }

        AccessoriesGroup::create(array_merge(['image' => $path], $validated));

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
            'code' => 'required|unique:accessories_groups,code,'.$this->edit_id,
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
