<?php

namespace App\Livewire\ProductSetting;

use App\Models\Assembly;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRemark;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ProductDetail extends Component
{
    use WireUiActions;

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

    // Confirm noti sent
    public function deletePhotoConfirmation($photoId)
    {
        $this->notification()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'If you delete, this\'s your responsible.',
            'icon' => 'question',
            'accept' => [
                'label' => 'Delete',
                'method' => 'deletePhoto',
                'params' => $photoId,
            ],
            'reject' => [
                'label' => 'Not yet',
                'method' => 'onClose',
            ],
            // 'onDismiss' => [
            //     'method' => 'cancleConfirm',
            //     'params' => ['event' => 'onDismiss'],
            // ],

        ]);
    }

    public function deletePhoto($id)
    {
        if (! auth()->user()->can('delete_product_photo')) {
            abort(403, 'Unauthorized action.');
        }

        $photo = ProductImage::findOrFail($id);

        $photoCount = ProductImage::where('product_id', $photo->product_id)->count();

        if ($photoCount == 1) {
            $this->notification()->error('You can\'t delete the last photo.');

            return;
        }

        $file = public_path('storage/'.$photo->image);
        if (file_exists($file)) {
            unlink($file);
        }

        $photo->delete();
    }

    #[Title('Read Product')]
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
