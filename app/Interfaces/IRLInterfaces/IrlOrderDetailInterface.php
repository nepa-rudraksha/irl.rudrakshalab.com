<?php

namespace App\Interfaces\IRLInterfaces;
use Illuminate\Http\UploadedFile;

interface IrlOrderDetailInterface{

    public function saveOrderDetail($reference_no);
    public function deselectOrderDetail($request);
}

?>