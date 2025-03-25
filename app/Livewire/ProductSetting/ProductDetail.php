<?php

namespace App\Livewire\ProductSetting;

use App\Models\Assembly;
use App\Models\Product;
use App\Models\ProductRemark;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductDetail extends Component
{
    #[Url(as: 'id')]
    public $product_id;

    public $employee_id;

    public $remark;

    public function mount()
    {
        $this->read();
    }

    public function createRemark()
    {
        $this->validate([
            'remark' => 'required|string',
        ]);

        ProductRemark::create([
            'product_id' => $this->product_id,
            'remark' => $this->remark,
            'type' => ProductRemark::TYPE['MANUAL'],
            'user_id' => auth()->user()->id,
            'employee_id' => $this->employee_id,
        ]);

        $this->reset('remark');
    }

    public function read()
    {
        $product = Product::find($this->product_id);

        $emp_data = Assembly::where('id', $product->assembly_id)->first()->employee_id;

        if ($emp_data == null) {
            $this->employee_id = null;
        } else {
            $this->employee_id = $emp_data;
        }
    }

    #[Title('Product Detail')]
    public function render()
    {
        return view('livewire.product-setting.product-detail', [
            'product' => Product::find($this->product_id),
        ]);
    }
}
