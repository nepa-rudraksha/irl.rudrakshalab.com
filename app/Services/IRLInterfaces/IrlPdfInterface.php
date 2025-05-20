<?php

namespace App\Services\IRLInterfaces;
use Illuminate\Http\UploadedFile;

interface IrlPdfInterface{

    public function saveOrderDetail($reference_no);

    public function getReferenceNo();
    public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf,string $order_id);
    public function savePDFTemp($order_no,$pdf);
    public function getOrderId();
}

?>