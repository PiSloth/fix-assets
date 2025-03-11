<?php

namespace App\Http\Controllers\Pdf;



use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
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
        $html = View::make('livewire.sale.invoice-test', ['new' => $new])->render();  // Myanmar text
        $mpdf->WriteHTML($html);

        // Output the PDF to the browser
        $mpdf->Output();
        // dd("Helo");
        // $mpdf = new Mpdf();
        // $mpdf->WriteHTML('<h1>မြန်မာစာ</h1>');
        // $mpdf->Output('example.pdf', 'D');
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

            // for ($i = 0; $i < 10; $i++) {
            //     $this->invoice_items[] = [

            //         'product' => Rabbit::uni2zg($item->branchProduct->product->name),
            //         'price' => $item->price,
            //         'quantity' => $item->quantity,
            //         'total' => $item->total,

            //     ];
            // }


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
