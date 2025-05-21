<?php
namespace App\Services\IRLInterfaces;
use App\Models\IrlReport;

use Carbon\Carbon;

use App\Services\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Support\Facades\Crypt;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

interface IrlPdfInterface{
    public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf,string $order_id);
    public function savePDFTemp($order_no,$pdf);
    public function getOrderId();
}