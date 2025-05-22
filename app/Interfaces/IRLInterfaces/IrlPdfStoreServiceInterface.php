<?php

namespace App\Interfaces\IRLInterfaces;

interface IrlPdfStoreServiceInterface{
    public function savePDFAuto($skuNo,$referenceNo,$pdf);
    public function savePDFTemp($order_no,$pdf);
}