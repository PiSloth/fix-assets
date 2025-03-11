<?php

namespace App\Livewire\Company;

use App\Models\Department;
use App\Models\Employee as ModelsEmployee;
use App\Models\Position;
use Exception;
use Livewire\Attributes\Title;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Employee extends Component
{
    use WireUiActions;
    public $name;
    public $stt_id;
    public $position_id;
    public $delete_id;
    public $department_id;
    public $phone;

    public $edit_id;

    public $up_name;
    public $up_stt_id;
    public $up_position_id;
    public $up_department_id;
    public $up_phone;


    public function create()
    {
        $validated = $this->validate([
            'name' => 'required|unique:employees,name',
            'phone' => 'required',
            'stt_id' => 'required|unique:employees,stt_id,',
            'department_id' => 'required',
            'position_id' => 'required',
        ]);

        ModelsEmployee::create($validated);
        $this->dispatch('closeModal', 'newModal');


        $this->reset('name', 'stt_id', 'phone', 'department_id', 'position_id');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Employee creation was successfully.'
        ]);
    }

    public function update()
    {
        $this->validate([

            'up_name' => 'required|unique:branches,name,' . $this->edit_id,
            'phone' => 'required',
            'stt_id' => 'required|unique:employees,stt_id,' . $this->edit_id,
            'department_id' => 'required',
            'position_id' => 'required',
        ]);

        $branch = ModelsEmployee::find($this->edit_id);
        $branch->update([
            'name' => $this->up_name,
            'phone' => $this->up_phone,
            'stt_id' => $this->up_stt_id,
            'position_id' => $this->up_position_id,
            'department_id' => $this->up_department_id
        ]);

        $this->dispatch('closeModal', 'editModal');

        $this->reset('up_name', 'up_position_id', 'edit_id', 'up_phone', 'up_department_id', 'up_stt_id');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Branch updated was successfully.'
        ]);
    }

    public function edit($id)
    {
        $query = ModelsEmployee::find($id);
        $this->up_name = $query->name;
        $this->up_stt_id = $query->address;
        $this->up_position_id = $query->address;
        $this->up_department_id = $query->address;
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
            ModelsEmployee::find($this->delete_id)->delete();
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

    #[Title('Supermen')]

    public function render()
    {
        return view('livewire.company.employee', [
            'departments' => Department::all(),
            'positions' => Position::all(),
            'employees' => ModelsEmployee::all()
        ]);
    }
}
