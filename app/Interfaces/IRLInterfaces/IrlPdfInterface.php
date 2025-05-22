<?php
namespace App\Interfaces\IRLInterfaces;

use Illuminate\Http\UploadedFile;

interface IrlPdfInterface{
    public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf,string $order_id);
    public function savePDFTemp($order_no,$pdf);
    public function getOrderId();
}