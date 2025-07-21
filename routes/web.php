<?php

use App\Http\Controllers\Pdf\InvoiceController;
use App\Livewire\Company\Branch as CompanyBranch;
use App\Livewire\Company\Department;
use App\Livewire\Company\Employee;
use App\Livewire\Company\Position;
use App\Livewire\Config\Setting\User;
use App\Livewire\Config\Setting\UserPermission;
use App\Livewire\FixAsset\AssemblyDetail;
use App\Livewire\FixAsset\Asset;
use App\Livewire\FixAsset\OwnershipPreview;
use App\Livewire\FixAsset\TransferAssembly;
use App\Livewire\ProductSetting\Accessory;
use App\Livewire\ProductSetting\AccessoryConfig;
use App\Livewire\ProductSetting\ProductDetail;
use App\Livewire\ProductSetting\VerifyReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

// use Mpdf\Mpdf;

// require_once __DIR__ . '/vendor/autoload.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::get('/pdf/{id}', [InvoiceController::class, 'ownership']);
Route::get('/pdf/ownership/{id}', [InvoiceController::class, 'changeOwnership']);
// Route::get('/pdf', function () {

// $mpdf = new mPDF();
// $mpdf->WriteHTML('<h1>မြန်မာစာ</h1>');
// $mpdf->Output('example.pdf', 'D');

// $pdf = SnappyPdf::loadHTML('<h1>မြန်မာစာ</h1>');
// return $pdf->download('example.pdf');

// $new = ['name' => "မောင်ပိုင်", "nick name", "ကဘူးကီ"];

// $data = ['Pos', 'God of Men'];
// $pdf = SnappyPdf::loadView('livewire.sale.invoice-test', ['new' => $new]);
// return $pdf->download('example.pdf');
// });

// Route::get('/test', function () {

//     $new = ['name' => "မောင်ပိုင်", "nick name", "ကဘူးကီ"];

//     $html = view('livewire.sale.invoice-test', ['new' => $new])->render();

//     $pdf = Browsershot::html($html)
//         ->pdf();

//     return Response($pdf, 200, [
//         'Content-Type' => 'application/pdf',
//         'Content-Disposition' => 'attachment; filename="example.pdf"',
//         'Content-Length' => strlen($pdf)
//     ]);
// });

Route::middleware(['auth'])->prefix('product')->group(function () {
    Route::get('/accessory-config', AccessoryConfig::class)->name('accessory-config');
    Route::get('/accessory', Accessory::class)->name('accessory');
    Route::get('/product/view', ProductDetail::class)->name('product-view');
});

Route::middleware(['auth'])->prefix('company')->group(function () {
    Route::get('/branch', CompanyBranch::class)->name('branch');
    Route::get('/department', Department::class)->name('department');
    Route::get('/position', Position::class)->name('position');
    Route::get('/employee', Employee::class)->name('employee');
});

Route::middleware(['auth'])->prefix('setting')->group(function () {
    Route::get('/user', User::class)->name('user-setting');
    Route::get('/permission', UserPermission::class)->name('user-permission');
});

Route::middleware(['auth'])->prefix('fix-asset')->group(function () {
    Route::get('/assets', Asset::class)->name('assets');
    Route::get('/assembly/detail', AssemblyDetail::class)->name('assembly.detail');
    Route::get('/assembly/transfer', TransferAssembly::class)->name('assembly.transfer');
    Route::get('/asset/ownership', OwnershipPreview::class)->name('ownership.preview');
    Route::get('/asset/report/verify', VerifyReport::class)->name('report.verify');

    // Route::get('/permission', UserPermission::class)->name('user-permission');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
