<?php

namespace App\Livewire\FixAsset;

use App\Models\Assembly;
use App\Models\Branch;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Asset extends Component
{
    use WireUiActions;
    use WithFileUploads;
    use WithPagination;

    public $name;

    public $code;

    public $remark;

    public $branch_id;

    public $department_id;

    public $employee_id;

    public $up_name;

    public $up_code;

    public $edit_id;

    public $image;

    public $department_filter;
    public $search;
    public $filter_result;

    public function create()
    {
        $validated = $this->validate([
            'name' => 'required',
            'department_id' => 'required',
            'branch_id' => 'required',
            'employee_id' => 'nullable',
        ]);

        $this->validate([
            'image' => 'required|image|max:1024',
        ]);

        $department = Department::find($this->department_id);
        $code = $department->short_name . '-' . Carbon::now()->format('jmy-His');

        $path = $this->image->store('images', 'tempublic');
        // dd($path);

        Assembly::create(array_merge([
            'remark' => $this->remark,
            'image' => $path,
            'code' => $code,
            'user_id' => auth()->user()->id,
        ], $validated));

        $this->dispatch('closeModal', 'newModal');
        $this->reset('name', 'code', 'image', 'image', 'department_id', 'branch_id');
    }

    public function read($id)
    {
        $query = Assembly::find($id);
        $this->up_name = $query->name;
        $this->department_id = $query->department_id;
        $this->branch_id = $query->branch_id;
        $this->remark = $query->remark;

        $this->edit_id = $id;
        $this->dispatch('openModal', 'editModal');
    }

    public function update()
    {

        $this->validate([
            'up_name' => 'required',
            'up_department_id' => 'required',
            'up_branch_id' => 'required',
        ]);

        Assembly::find($this->edit_id)->update([
            'accessories_group_id' => $this->accessories_group_id,
            'name' => $this->up_name,
            'department_id' => $this->up_department_id,
            'branch_id' => $this->up_branch_id,
            'remark' => $this->up_remark,
        ]);

        $this->reset('up_name', 'up_code', 'edit_id', 'accessories_group_id');
        $this->dispatch('closeModal', 'editModal');
    }

    public function cancle_image()
    {
        $this->reset('image');
    }

    public function getPdf()
    {
        return redirect('/pdf/1');
    }

    #[Title('Asset')]
    public function render()
    {


        $assembly = DB::table('assemblies')->select('assemblies.*', 'e.name AS eName', 'd.name AS dName', 'v.status as status')
            ->leftJoin('employees as e', 'e.id', '=', 'assemblies.employee_id')
            ->leftJoin('departments as d', 'd.id', 'assemblies.department_id')
            ->leftJoin(DB::raw('
        (
            SELECT MAX(id) as id, assembly_id
            FROM verifies
            GROUP BY assembly_id
        ) as latest_v
    '), 'latest_v.assembly_id', '=', 'assemblies.id')
            ->leftJoin('verifies as v', 'v.id', '=', 'latest_v.id')

            ->when($this->department_filter, function ($query) {
                $query->where('d.id', $this->department_filter);
            })
            ->when($this->search, function ($query) {
                $query->where('assemblies.name', 'like', "%{$this->search}%")
                    ->orWhere('assemblies.code', 'like', "%{$this->search}%")
                    ->orWhere('e.name', 'like', "%{$this->search}%");
            });

        $this->filter_result[] = $assembly->get();
        // ->get();


        // $this->filter_result = [];

        // foreach ($assembly as $item) {
        //     $this->filter_result = [
        //         'id' =>
        //     ];
        // }




        // $assembly = Assembly::select('assemblies.*')
        //     ->when($this->department_filter, function ($query) {
        //         $query->where('department_id', $this->department_filter);
        //     })
        //     ->when($this->search, function ($query) {
        //         $query->where('name', 'like', "%{$this->search}%")
        //             ->orWhere('code', 'like', "%{$this->search}%");
        //     })
        //     ->paginate(10);

        // $assets = Assembly::when($this->department_id, function ($query) {
        //     $query->where('department_id', $this->department_id);
        // })->get();
        $assembly = $assembly->paginate(10);

        return view('livewire.fix-asset.asset', [
            // 'assets' => $assets,
            'assemblies' => $assembly,
            'departments' => Department::all(),
            'branches' => Branch::all(),
        ]);
    }
}
