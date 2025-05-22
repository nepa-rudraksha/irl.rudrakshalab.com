<?php

namespace App\Interfaces\IRLInterfaces;

interface IrlReportRepositoryInterface{
    public function findBySkuAndReference(string $skuNo,string $referenceNo);
}