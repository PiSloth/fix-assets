<?php

namespace App\Livewire\Company;

use Livewire\Attributes\Title;
use Livewire\Component;
use WireUi\Traits\WireUiActions;
use App\Models\Branch as ModelsBranch;
use Exception;

class Branch extends Component
{
    use WireUiActions;
    public $name;
    public $address;
    public $edit_id;
    public $delete_id;
    public $phone;

    public $up_name;
    public $up_address;
    public $up_phone;


    public function create()
    {
        $validated = $this->validate([
            'name' => 'required|unique:branches,name',
            'phone' => 'required',
            'address' => 'nullable'
        ]);

        ModelsBranch::create($validated);
        $this->dispatch('closeModal', 'newModal');


        $this->reset('name', 'address', 'phone');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Branch creation was successfully.'
        ]);
    }

    public function update()
    {
        $this->validate([

            'up_name' => 'required|unique:branches,name,' . $this->edit_id,
            'up_phone' => 'required',

        ]);
        $branch = ModelsBranch::find($this->edit_id);
        $branch->update([
            'name' => $this->up_name,
            'address' => $this->up_address,
            'phone' => $this->up_phone,
        ]);

        $this->dispatch('closeModal', 'editModal');

        $this->reset('up_name', 'up_address', 'edit_id', 'up_phone');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Branch updated was successfully.'
        ]);
    }

    public function edit($id)
    {
        $query = ModelsBranch::find($id);
        $this->up_name = $query->name;
        $this->up_address = $query->address;
        $this->up_phone = $query->phone;

        $this->edit_id = $id;

        $this->dispatch('openModal', 'editModal');
    }

    public function cancleEdit()
    {
        $this->reset('up_name', 'up_address', 'edit_id', 'up_phone');
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
            ModelsBranch::find($this->delete_id)->delete();
        } catch (Exception $e) {
            if ($e->getCode() == '23000') {
                $this->dialog()->show([
                    'icon' => 'error',
                    'title' => 'Failed!',
                    'description' => 'Can\'t delete this item coz of use in another record.'
                ]);
                $this->dispatch('close-modal', 'confirm-branch-delete');
                return;
            } else {
                $this->dialog()->show([
                    'icon' => 'error',
                    'title' => 'Failed!',
                    'description' => 'Can\'t delete this branch.'
                ]);
                $this->dispatch('close-modal', 'confirm-branch-delete');
                return;
            }
        }

        $this->dispatch('closeModal', 'confirm-branch-delete');

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Branch deleted was successfully.'
        ]);
    }

    #[Title('Group of business')]
    public function render()
    {
        return view('livewire.company.branch', [
            'branches' => ModelsBranch::all(),
        ]);
    }
}
