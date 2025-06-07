<?php

namespace App\Livewire\FixAsset;

use App\Models\Assembly;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockTransfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class AssemblyDetail extends Component
{
    use WithFileUploads;

    #[Url(as: 'id')]
    public $assembly_id;

    public $employee_id;

    public $name;

    public $image;

    public $serial_number;

    public $purchase_date;

    public $warranty_date;

    public $purchase_price;

    public $purchase_from;

    public $remark;

    public $description;

    public $product_id;

    public $product_name;

    public $images;

    public $update_assembly_image;

    public $up_ass_name, $up_branch_id, $up_dep_id;

    public $transfered_assembly_id;

    public function mount()
    {
        $assembly = Assembly::findOrFail($this->assembly_id);

        $this->up_ass_name = $assembly->name;
        $this->up_branch_id = $assembly->branch_id;
        $this->up_dep_id = $assembly->department_id;
    }
    public function assign()
    {
        $this->validate([
            'employee_id' => 'required',
        ]);

        $query = Assembly::find($this->assembly_id);

        $query->update([
            'employee_id' => $this->employee_id,
        ]);

        $this->dispatch('closeModal', 'responsibleTo');
        $this->reset('employee_id');
    }

    public function updateAssembly()
    {
        $this->validate([
            'up_ass_name' => 'required',
            'up_dep_id' => 'required',
            'up_branch_id' => 'required'
        ]);

        $query = Assembly::findOrFail($this->assembly_id);

        $query->update([
            'name' => $this->up_ass_name,
            'department_id' => $this->up_dep_id,
            'branch_id' => $this->up_branch_id
        ]);

        $this->dispatch('closeModal', 'editAssemblyModal');
    }

    public function create()
    {
        $code = 'P' . Carbon::now()->format('ymdHis');
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        DB::transaction(function () use ($code) {
            $product = Product::create([
                'assembly_id' => $this->assembly_id,
                'serial_number' => $this->serial_number,
                'purchase_date' => $this->purchase_date,
                'warranty_date' => $this->warranty_date,
                'purchase_price' => $this->purchase_price,
                'purchase_from' => $this->purchase_from,
                'code' => $code,
                'name' => $this->name,
                'remark' => $this->remark,
                'description' => $this->description,
            ]);

            $path = $this->image->store('images', 'tempublic');

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
            ]);
        });

        $this->dispatch('closeModal', 'newModal');
        $this->reset('name', 'serial_number', 'purchase_date', 'warranty_date', 'purchase_price', 'purchase_from', 'remark', 'description');
    }



    public function addProductModal($id, $name)
    {
        // dd($name);

        $this->product_id = $id;
        $this->product_name = $name;
        $this->dispatch('openModal', 'imageUpload');
    }

    public function addPhoto()
    {
        $this->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $path = $this->image->store('images', 'tempublic');
        ProductImage::create([
            'product_id' => $this->product_id,
            'image' => $path,
        ]);

        $this->dispatch('closeModal', 'imageUpload');
        $this->reset('image', 'product_id');
    }

    public function cancle_assembly_image()
    {
        $this->reset('update_assembly_image');
    }

    public function updateAssemblyImage()
    {
        $this->validate([
            'update_assembly_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $assembly = Assembly::findOrFail($this->assembly_id);

        $file = public_path('storage/' . $assembly->image);

        if (file_exists($file)) {
            unlink($file);
        }

        $path = $this->update_assembly_image->store('images', 'tempublic');

        $assembly->update([
            'image' => $path,
        ]);

        $this->dispatch('closeModal', 'assemblyImageUpload');
        $this->reset('update_assembly_image');
    }

    public function viewPhotos($id, $name)
    {
        // dd("Hello");
        $this->product_name = $name;
        $this->images = ProductImage::whereProductId($id)->get();

        $this->dispatch('openModal', 'viewImage');
    }

    public function cancle_image()
    {
        $this->reset('image');
    }

    //initialize trasfer modal
    public function initializeTransferModal($id)
    {
        $this->product_id = $id;
        $this->dispatch('openModal', 'transferModal');
    }

    //product transfer
    public function transfer()
    {
        DB::transaction(function () {
            $query = Product::find($this->product_id);

            $query->update([
                'assembly_id' => $this->transfered_assembly_id
            ]);

            StockTransfer::create([
                'product_id' => $this->product_id,
                'user_id' => auth()->user()->id,
                'original_assembly_id' => $this->assembly_id,
                'transfered_assembly_id' => $this->transfered_assembly_id,
                'remark' => $this->remark
            ]);
        });

        $this->reset('product_id', 'remark', 'transfered_assembly_id');
        $this->dispatch('closeModal', 'transferModal');
    }

    #[Title('Assembly Detail')]
    public function render()
    {
        $transfers = StockTransfer::where("original_assembly_id", '=', $this->assembly_id)->get();



        return view('livewire.fix-asset.assembly-detail', [
            'products' => Product::whereAssemblyId($this->assembly_id)->get(),
            'assembly' => Assembly::find($this->assembly_id),
            'departments' => Department::all(),
            'branches' => Branch::all(),
            'transfers' => $transfers,
        ]);
    }
}
