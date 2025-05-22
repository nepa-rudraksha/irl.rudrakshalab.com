<?php
namespace App\Repositories;

use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;
use App\Models\IrlReport;

class IrlReportRepository implements IrlReportRepositoryInterface{
    public function findBySkuAndReference(string $skuNo,string $referenceNo){

        return IrlReport::where('SKU_no', $skuNo)
                ->where('reference_no', $referenceNo)
                ->first();

    }
}

