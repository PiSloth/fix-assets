<?php

namespace App\Livewire\FixAsset;

use App\Models\Assembly;
use App\Models\Product;
use App\Models\ProductImage;
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

    public function create()
    {
        $code = 'P'.Carbon::now()->format('ymdHis');
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

    public function viewPhotos($id, $name)
    {
        $this->product_name = $name;
        $this->images = ProductImage::whereProductId($id)->get();

        $this->dispatch('openModal', 'viewImage');
    }

    #[Title('Assembly Detail')]
    public function render()
    {
        return view('livewire.fix-asset.assembly-detail', [
            'products' => Product::whereAssemblyId($this->assembly_id)->get(),
            'assembly' => Assembly::find($this->assembly_id),
        ]);
    }
}
