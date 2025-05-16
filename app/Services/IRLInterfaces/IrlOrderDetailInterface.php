<?php

namespace App\Services\IRLInterfaces;
use Illuminate\Http\UploadedFile;

interface IrlOrderDetailInterface{

    public function saveOrderDetail($reference_no);

    public function getReferenceNo();
    public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf);
    public function deselectOrderDetail($request);

}

?>