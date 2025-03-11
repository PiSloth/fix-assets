<?php

namespace App\Livewire\Company;

use App\Models\Position as ModelsPosition;
use Exception;
use Livewire\Attributes\Title;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Position extends Component
{

    use WireUiActions;
    public $name;

    public $edit_id;
    public $delete_id;


    public $up_name;



    public function create()
    {
        $validated = $this->validate([
            'name' => 'required|unique:positions,name',
        ]);

        ModelsPosition::create($validated);
        $this->dispatch('closeModal', 'newModal');


        $this->reset('name');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'position creation was successfully.'
        ]);
    }

    public function update()
    {
        $this->validate([
            'up_name' => 'required|unique:positions,name,' . $this->edit_id,

        ]);
        $position = ModelsPosition::find($this->edit_id);
        $position->update([
            'name' => $this->up_name,
        ]);

        $this->dispatch('closeModal', 'editModal');

        $this->reset('up_name',  'edit_id');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Position updated was successfully.'
        ]);
    }

    public function edit($id)
    {
        $query = ModelsPosition::find($id);
        $this->up_name = $query->name;

        $this->edit_id = $id;

        $this->dispatch('openModal', 'editModal');
    }

    public function cancleEdit()
    {
        $this->reset('up_name', 'edit_id');
    }

    // Delection

    public function setDelete($id)
    {
        $this->delete_id = $id;
    }

    public function cancleDelete()
    {
        $this->reset('delete_id');
    }

    public function  delete()
    {

        try {
            ModelsPosition::find($this->delete_id)->delete();
        } catch (Exception $e) {
            if ($e->getCode() == '23000') {
                $this->dialog()->show([
                    'icon' => 'error',
                    'title' => 'Failed!',
                    'description' => 'Can\'t delete this item coz of use in another record.'
                ]);
                $this->dispatch('close-modal', 'confirm-position-delete');
                return;
            } else {
                $this->dialog()->show([
                    'icon' => 'error',
                    'title' => 'Failed!',
                    'description' => 'Can\'t delete this position.'
                ]);
                $this->dispatch('close-modal', 'confirm-position-delete');
                return;
            }
        }

        $this->dispatch('closeModal', 'confirm-position-delete');

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Position deleted was successfully.'
        ]);
    }

    #[Title('Take you positions.')]

    public function render()
    {
        return view('livewire.company.position', [
            'positions' => ModelsPosition::all(),
        ]);
    }
}
