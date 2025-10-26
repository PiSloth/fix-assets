<?php

namespace App\Livewire\FixAsset;

use App\Exports\ProductsExport;
use App\Models\Assembly;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
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

    public $up_remark;

    public $up_department_id;

    public $up_branch_id;

    public $edit_id;

    public $image;

    public $department_filter;
    public $search;
    public $filter_result;
    public $is_active_filter;

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
        $this->up_department_id = $query->department_id;
        $this->up_branch_id = $query->branch_id;
        $this->up_remark = $query->remark;

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
            'name' => $this->up_name,
            'department_id' => $this->up_department_id,
            'branch_id' => $this->up_branch_id,
            'remark' => $this->up_remark,
        ]);

        $this->reset('up_name', 'up_code', 'edit_id');
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

    public function toggleActive($id)
    {
        $assembly = Assembly::find($id);
        $assembly->update(['is_active' => !$assembly->is_active]);
        $this->notification()->success('Status updated successfully!');
    }

    public function exportProducts()
    {
        // Build the assembly query with filters
        $assemblyQuery = Assembly::with([
            'department:id,name',
            'branch:id,name',
            'employee:id,name',
            'latestVerify:id,status'
        ])
            ->select('assemblies.*')
            ->where('is_active', true)
            ->when($this->department_filter, function ($q) {
                $q->where('department_id', $this->department_filter);
            })
            ->when($this->search, function ($q) {
                $q->where(function ($subQ) {
                    $subQ->where('assemblies.name', 'like', "%{$this->search}%")
                        ->orWhere('assemblies.code', 'like', "%{$this->search}%")
                        ->orWhereHas('employee', function ($empQ) {
                            $empQ->where('name', 'like', "%{$this->search}%");
                        });
                });
            });

        // Get assembly IDs
        $assemblyIds = $assemblyQuery->pluck('id');

        // Build products query with assembly data
        $productsQuery = Product::with([
            'assembly' => function ($q) {
                $q->with('department:id,name', 'branch:id,name', 'employee:id,name');
            }
        ])
            ->select('products.*')
            ->whereIn('assembly_id', $assemblyIds);

        return Excel::download(new ProductsExport($productsQuery), 'products.xlsx');
    }

    #[Title('Asset')]
    public function render()
    {
        // Refactored query using Eloquent for better readability and maintainability
        $query = Assembly::with([
            'department:id,name',
            'branch:id,name',
            'employee:id,name',
            'latestVerify:id,status'
        ])
            ->select('assemblies.*')
            ->where('is_active', true)
            ->when($this->department_filter, function ($q) {
                $q->where('department_id', $this->department_filter);
            })
            ->when(
                $this->search,
                function ($q) {
                    $q->where(function ($subQ) {
                        $subQ->where('assemblies.name', 'like', "%{$this->search}%")
                            ->orWhere('assemblies.code', 'like', "%{$this->search}%")
                            ->orWhereHas('employee', function ($empQ) {
                                $empQ->where('name', 'like', "%{$this->search}%");
                            });
                    });
                }
            );

        $assemblies = $query->paginate(10);

        return view('livewire.fix-asset.asset', [
            'assemblies' => $assemblies,
            'departments' => Department::all(),
            'branches' => Branch::all(),
        ]);
    }
}
