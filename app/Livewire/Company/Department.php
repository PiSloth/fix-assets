<?php

namespace App\Livewire\Company;

use App\Models\Department as ModelsDepartment;
use Exception;
use Livewire\Attributes\Title;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Department extends Component
{
    use WireUiActions;
    public $name;

    public $edit_id;
    public $delete_id;
    public $short_name;

    public $up_short_name;


    public $up_name;


    public function create()
    {
        $validated = $this->validate([
            'name' => 'required|unique:departments,name',
            'short_name' => 'required|unique:departments,short_name',
        ]);

        // dd($validated);

        ModelsDepartment::create($validated);


        $this->dispatch('closeModal', 'newModal');

        $this->reset('name', 'short_name');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'department creation was successfully.'
        ]);
    }

    public function update()
    {
        $this->validate([
            'up_name' => 'required|unique:departments,name,' . $this->edit_id,
            'up_short_name' => 'required|unique:departments,short_name,' . $this->edit_id,
        ]);
        $department = ModelsDepartment::find($this->edit_id);

        $department->update([
            'name' => $this->up_name,
            'short_name' => $this->up_short_name,
        ]);

        $this->dispatch('closeModal', 'editModal');

        $this->reset('up_name',  'edit_id', 'up_short_name');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Department updated was successfully.'
        ]);
    }

    public function edit($id)
    {
        $query = ModelsDepartment::find($id);
        $this->up_name = $query->name;
        $this->up_short_name = $query->short_name;

        $this->edit_id = $id;

        $this->dispatch('openModal', 'editModal');
    }

    public function cancleEdit()
    {
        $this->reset('up_name', 'edit_id', 'up_short_name');
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
            ModelsDepartment::find($this->delete_id)->delete();
        } catch (Exception $e) {
            if ($e->getCode() == '23000') {
                $this->dialog()->show([
                    'icon' => 'error',
                    'title' => 'Failed!',
                    'description' => 'Can\'t delete this item coz of use in another record.'
                ]);
                $this->dispatch('close-modal', 'confirm-department-delete');
                return;
            } else {
                $this->dialog()->show([
                    'icon' => 'error',
                    'title' => 'Failed!',
                    'description' => 'Can\'t delete this department.'
                ]);
                $this->dispatch('close-modal', 'confirm-department-delete');
                return;
            }
        }

        $this->dispatch('closeModal', 'confirm-department-delete');

        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'department deleted was successfully.'
        ]);
    }

    #[Title('Department of department')]

    public function render()
    {
        return view('livewire.company.department', [
            'departments' => ModelsDepartment::all()
        ]);
    }
}
