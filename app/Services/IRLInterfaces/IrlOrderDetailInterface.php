<?php

namespace App\Services\IRLInterfaces;
use Illuminate\Http\UploadedFile;

interface IrlOrderDetailInterface{

    public function saveOrderDetail($reference_no);
    public function getReferenceNo();
    public function deselectOrderDetail($request);
}

?>