<?php

namespace App\Http\Controllers\Pdf;



use App\Http\Controllers\Controller;
use App\Models\Assembly;
use App\Models\OwnershipChange;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\Url;
use Mpdf\Mpdf;
use Spatie\Browsershot\Browsershot;

use Googlei18n\MyanmarTools\ZawgyiDetector;
use Rabbit;

class InvoiceController extends Controller
{

    public $invoice_id;
    public $customer_info = [];
    public $branch_info = [];
    public $invoice_items = [];
    public $invoice_info = [];

    public function testController()
    {
        $output = Rabbit::uni2zg("ချယ်ရီ");


        // $fontPath = storage_path('fonts/.ttf');

        // Create a new instance of mPDF
        $mpdf = new Mpdf([
            'fontDir' => [storage_path('fonts')],
            'fontdata' => [
                'myan3' => [
                    'R' => 'ZawgyiOne.ttf', // Regular weight
                ]
            ]
        ]);

        // Set font to Zawgyi
        $mpdf->SetFont('myan3');

        $new = ['name' => "သီဟိုဠ္မွ ဉာဏ္ႀကီးရွင္သည္ အာယုဝၯနေဆးၫႊန္းစာကို ဇလြန္ေဈးေဘး ဗာဒံပင္ထက္ အဓိ႒ာန္လ်က္ ဂဃနဏဖတ္ခဲ့သည္။", "nick name", $output];

        // Write HTML content
        $html = View::make('livewire.fix-asset.ownership-pdf', ['new' => $new])->render();  // Myanmar text
        $mpdf->WriteHTML($html);

        // Output the PDF to the browser
        $mpdf->Output();
        // dd("Helo");
        // $mpdf = new Mpdf();
        // $mpdf->WriteHTML('<h1>မြန်မာစာ</h1>');
        // $mpdf->Output('example.pdf', 'D');
    }

    public function ownership($id)
    {
        // Create a new instance of mPDF
        $mpdf = new Mpdf([
            'format' => 'A4',
            'fontDir' => [storage_path('fonts')],
            'fontdata' => [
                'myan3' => [
                    'R' => 'ZawgyiOne.ttf', // Regular weight
                ]
            ]
        ]);

        // Set font to Zawgyi
        $mpdf->SetFont('myan3');

        $data = [];

        $assembly = Assembly::find($id);

        $data['title'] = ['text' => Rabbit::uni2zg("တာဝန်ယူထားသော ပစ္စည်းများစာရင်း")];


        $data['assembly'] = [
            'name' => Rabbit::uni2zg($assembly->name),
            'code' => $assembly->code,
            'remark' => Rabbit::uni2zg($assembly->remark),
            'location' => Rabbit::uni2zg($assembly->branch->name),
            'image' => $assembly->image,
        ];

        $data['responsible'] = [
            'name' => Rabbit::uni2zg($assembly->employee->name),
            'stt_id' => $assembly->employee->stt_id,
            'phone' => Rabbit::uni2zg($assembly->employee->phone),
            'department' => Rabbit::uni2zg($assembly->employee->department->name),
            'position' => Rabbit::uni2zg($assembly->employee->position->name),
        ];

        $products = Product::where("assembly_id", $assembly->id)
            ->get();

        $product_data = [];

        foreach ($products as $item) {
            if (!isset($this->product_data[$item->code])) {
                $product_data[$item->code] = [
                    'name' =>  Rabbit::uni2zg($item->name),
                    'desc' =>  Rabbit::uni2zg($item->description),
                    'remark' =>  Rabbit::uni2zg($item->remark),
                    'serial' => $item->serial_number,
                    'image' => $item->images->first()->image,
                ];
            }
        }

        // Write HTML content
        $html = View::make('livewire.fix-asset.ownership-pdf', ['data' => $data, 'products' =>   $product_data])->render();  // Myanmar text
        $mpdf->WriteHTML($html);

        // Output the PDF to the browser
        $mpdf->Output();
    }

    public function changeOwnership($id)
    {
        // Create a new instance of mPDF
        $mpdf = new Mpdf([
            'format' => 'A4',
            'fontDir' => [storage_path('fonts')],
            'fontdata' => [
                'myan3' => [
                    'R' => 'ZawgyiOne.ttf', // Regular weight
                ]
            ]
        ]);

        // Set font to Zawgyi
        $mpdf->SetFont('myan3');

        $data = [];

        $changeHistory = OwnershipChange::find($id);

        $assembly = Assembly::find($changeHistory->assembly_id);

        $data['title'] = ['text' => Rabbit::uni2zg("တာဝန်ပြောင်းလဲယူခြင်း")];

        $data['assembly'] = [
            'name' => Rabbit::uni2zg($assembly->name),
            'code' => $assembly->code,
            'remark' => Rabbit::uni2zg($assembly->remark),
            'location' => Rabbit::uni2zg($assembly->branch->name),
            'image' => $assembly->image,
        ];

        $data['responsible'] = [
            'name' => Rabbit::uni2zg($changeHistory->ownby->name),
            'stt_id' => $changeHistory->ownby->stt_id,
            'phone' => Rabbit::uni2zg($changeHistory->ownby->phone),
            'department' => Rabbit::uni2zg($changeHistory->ownby->department->name),
            'position' => Rabbit::uni2zg($changeHistory->ownby->position->name),
        ];

        $data['newOwner'] = [
            'name' => Rabbit::uni2zg($changeHistory->transferto->name),
            'stt_id' => $assembly->employee->stt_id,
            'phone' => Rabbit::uni2zg($changeHistory->transferto->phone),
            'department' => Rabbit::uni2zg($changeHistory->transferto->department->name),
            'position' => Rabbit::uni2zg($changeHistory->transferto->position->name),
            'termto' => Rabbit::uni2zg("လွှဲပြောင်းယူလိုက်ရသော အကြောင်းပြချက်"),
            'reason' => Rabbit::uni2zg($changeHistory->reason),
        ];

        $data['approver'] = [
            'name' => Rabbit::uni2zg($changeHistory->approver->name),
            'email' => Rabbit::uni2zg($changeHistory->approver->email),
        ];


        $products = Product::where("assembly_id", $assembly->id)
            ->get();

        $product_data = [];

        foreach ($products as $item) {
            if (!isset($this->product_data[$item->code])) {
                $product_data[$item->code] = [
                    'name' =>  Rabbit::uni2zg($item->name),
                    'desc' =>  Rabbit::uni2zg($item->description),
                    'remark' =>  Rabbit::uni2zg($item->remark),
                    'serial' => $item->serial_number,
                    'image' => $item->images->first()->image,
                ];
            }
        }

        // Write HTML content
        $html = View::make('livewire.fix-asset.ownership-change-pdf', ['data' => $data, 'products' =>   $product_data])->render();  // Myanmar text
        $mpdf->WriteHTML($html);

        // Output the PDF to the browser
        $mpdf->Output();
    }

    public function generateInvoice($id)
    {

        $invoice_items = [];

        foreach ($invoice_items as $item) {
            $this->invoice_items[] = [

                'product' => Rabbit::uni2zg($item->branchProduct->product->name),
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->total,
            ];

            if (!isset($this->branch_info[$item->branchProduct->branch->name])) {
                $this->branch_info[$item->branchProduct->branch->name] = [
                    'name' => $item->branchProduct->branch->name,
                    'address' => $item->branchProduct->branch->address,
                ];
            }
        }

        // dd($this->invoice_items);

        // $fontPath = storage_path('fonts/.ttf');

        // Create a new instance of mPDF
        $rows = count($this->invoice_items);

        $logoHeight = 150;
        // dd($rows);
        if ($rows < 10) {
            $rowHeight = 6;       // Estimated height per row in mm
        } elseif ($rows < 30) {
            $rowHeight = 8.5;
        } elseif ($rows < 25) {
            $rowHeight = 10;
        } elseif ($rows < 30) {
            $rowHeight = 10;
        } else {
            $rowHeight = 9;
        }

        $pageHeight = $rows * $rowHeight + $logoHeight;

        $mpdf = new Mpdf([
            'format' => [120, $pageHeight],
            'orientation' => 'P',
            'fontDir' => [storage_path('fonts')],
            'fontdata' => [
                'myan3' => [
                    'R' => 'ZawgyiOne.ttf', // Regular weight
                ]
            ]
        ]);

        $html = View::make('livewire.sale.invoice-print', [
            'customer_info' => $this->customer_info,
            'branch_info' => $this->branch_info,
            'invoice_items' => $this->invoice_items,
            'invoice_info' => $this->invoice_info,
        ])->render();  // Myanmar text
        $mpdf->SetAutoPageBreak(false); // Enable auto page breaks with a 10 mm bottom margin

        // $mpdf->SetMargins(5, 5, 5);

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
