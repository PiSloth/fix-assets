<?php

namespace App\Livewire\FixAsset;

use App\Models\Assembly;
use App\Models\Branch;
use App\Models\Department;
use App\Models\OwnershipChange;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\StockTransfer;
use App\Models\Verify;
use App\Models\VerifyPhoto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class AssemblyDetail extends Component
{
    use WithFileUploads;
    use WireUiActions;

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

    public $up_ass_name, $up_branch_id, $up_dep_id, $up_remark;

    public $transfered_assembly_id;

    public $ownby_id, $transferto_id, $approver_id, $reason;

    public $ownership_request;

    public $verify_photo, $verifyby_id, $verify_remark;

    public $verify_info;


    public function mount()
    {
        $assembly = Assembly::findOrFail($this->assembly_id);

        $this->up_ass_name = $assembly->name;
        $this->up_remark = $assembly->remark;
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
            'up_branch_id' => 'required',
            'up_remark' => 'nullable'
        ]);

        $query = Assembly::findOrFail($this->assembly_id);

        $query->update([
            'name' => $this->up_ass_name,
            'department_id' => $this->up_dep_id,
            'branch_id' => $this->up_branch_id,
            'remark' => $this->up_remark
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

    //request to ownership change
    public function ownerChange()
    {
        $assembly = Assembly::findOrFail($this->assembly_id);

        $this->validate([
            'transferto_id' => 'required',
            'approver_id' => 'required',
            'reason' => 'required',
        ]);

        //check if the requester is the same as the approver
        if ($this->approver_id == auth()->user()->id) {
            $this->notification()->send([
                'icon' => 'warning',
                'title' => 'Invalid Approver',
                'description' => 'You cannot approve your own request.',
            ]);
            return;
        }

        DB::transaction(function () use ($assembly) {
            OwnershipChange::create([
                'ownby_id' => $assembly->employee->id,
                'transferto_id' => $this->transferto_id,
                'approver_id' => $this->approver_id,
                'transferby_id' => auth()->user()->id,
                'assembly_id' => $this->assembly_id,
                'reason' => $this->reason,
            ]);
        });

        $this->reset('transferto_id', 'approver_id', 'reason');
        $this->dispatch('closeModal', 'ownershipModal');
    }

    //read Ownership transfer request
    public function readOwnership($id)
    {
        $query = OwnershipChange::find($id);

        $this->ownership_request = [
            'id' => $query->id,
            'ownby' => $query->ownby->name,
            'transferto' => $query->transferto->name,
            'postby' => $query->transferby->name,
            'approver' => $query->approver->name,
            'reason' => $query->reason,
        ];

        $this->dispatch('openModal', 'approverModal');
    }

    //Approver transfer form
    public function approveChanges()
    {

        $query = OwnershipChange::find($this->ownership_request['id']);
        $assembly = Assembly::find($this->assembly_id);


        if ($query->approver_id !== auth()->user()->id) {
            $this->notification()->send([
                'icon' => 'info',
                'title' => 'Unauthorized',
                'description' => 'You are not allowed to edit!',
            ]);
            return;
        }

        DB::transaction(function () use ($query, $assembly) {
            $query->update([
                'status' => 'approve'
            ]);

            $assembly->update([
                'employee_id' => $query->transferto_id
            ]);
        });

        $this->dispatch('closeModal', 'approveModal');
    }

    public function rejectChanges()
    {
        $query =   OwnershipChange::find($this->ownership_request['id']);

        if ($query->approver_id !== auth()->user()->id) {
            $this->notification()->send([
                'icon' => 'info',
                'title' => 'Unauthorized',
                'description' => 'You are not allowed to edit!',
            ]);
            return;
        }

        $query->update([
            'status' => 'reject'
        ]);

        $this->dispatch('closeModal', 'approveModal');
    }

    //verify this assembly by Superior person
    public function verify()
    {
        $this->validate([
            'verifyby_id' => 'required',
            'remark' => 'nullable',
            'verify_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);


        $assembly = Assembly::find($this->assembly_id);
        $path = $this->verify_photo->store('photos', 'verifyPhoto');

        $verifyStatus = Verify::where('assembly_id', $this->assembly_id)
            ->where('status', 'pending')
            ->orderBy('id', 'desc')
            ->first();

        //verify if there is pending request
        if ($verifyStatus) {
            $this->dispatch('closeModal', 'verifyModal');

            $this->notification()->send([
                'icon' => 'warning',
                'title' => 'Pending Verification Exists',
                'description' => 'There is already a pending verification request for this assembly.',
            ]);
            return;
        }

        //reject if the verifier is the same as the requester
        if ($this->verifyby_id == auth()->user()->id) {
            $this->dispatch('closeModal', 'verifyModal');
            $this->notification()->send([
                'icon' => 'warning',
                'title' => 'Invalid Verifier',
                'description' => 'You cannot verify your own request.',
            ]);
            return;
        }

        DB::transaction(function () use ($assembly, $path) {
            $data = Verify::create([
                'requestby_id' => auth()->user()->id,
                'verifyby_id' => $this->verifyby_id,
                'assembly_id' => $this->assembly_id,
                'responsibleby_id' => $assembly->employee_id,
                'remark' => $this->verify_remark,
            ]);

            VerifyPhoto::create([
                'verify_id' => $data->id,
                'photo' => $path,
            ]);
        });

        $this->reset('verifyby_id', 'verify_remark', 'verify_photo');
        $this->dispatch('closeModal', 'verifyModal');
    }

    public function readVerifyRequest($id)
    {
        $query = Verify::find($id);

        $this->verify_info = [
            'id' => $query->id,
            'request_by' => $query->requestby->name,
            'photos' => $query->photos,
            'responsible_by' => $query->responsibleby->name,
        ];


        $this->dispatch('openModal', 'verifyAcceptModal');
    }

    public function verifyAccept()
    {
        $query = Verify::find($this->verify_info['id']);

        if ($query->verifyby_id !== auth()->user()->id) {
            $this->notification()->send([
                'icon' => 'info',
                'title' => 'Unauthorized',
                'description' => 'You are not allowed to edit!',
            ]);
            return;
        }

        $query->update([
            'status' => 'verified',
            'remark' => $this->verify_remark
        ]);

        $this->reset('verify_remark', 'verify_info');
        $this->dispatch('closeModal', 'verifyAcceptModal');
    }

    public function verifyReject()
    {
        $query = Verify::find($this->verify_info['id']);

        if ($query->verifyby_id !== auth()->user()->id) {
            $this->notification()->send([
                'icon' => 'info',
                'title' => 'Unauthorized',
                'description' => 'You are not allowed to edit!',
            ]);
            return;
        }

        $query->update([
            'status' => 'rejected',
            'remark' => $this->verify_remark
        ]);

        $this->reset('verify_remark', 'verify_info');
        $this->dispatch('closeModal', 'verifyAcceptModal');
    }

    public function cancle_verify_photo()
    {
        $this->verify_photo = '';
    }

    #[Title('Assembly Detail')]
    public function render()
    {
        $transfers = StockTransfer::where("original_assembly_id", '=', $this->assembly_id)
            ->orderBy('id', 'desc')
            ->get();
        $ownership_changes = OwnershipChange::where('assembly_id', '=', $this->assembly_id)
            ->orderBy('id', 'desc')
            ->get();
        $verify_data = Verify::where('assembly_id', '=', $this->assembly_id)
            ->orderBy('id', 'desc')
            ->get();

        // $verify = $verify_data->first()->status;
        // dd($verify);


        return view('livewire.fix-asset.assembly-detail', [
            'products' => Product::whereAssemblyId($this->assembly_id)->get(),
            'assembly' => Assembly::find($this->assembly_id),
            'departments' => Department::all(),
            'branches' => Branch::all(),
            'transfers' => $transfers,
            'ownership_changes' => $ownership_changes,
            'verify_data' => $verify_data,
        ]);
    }
}
