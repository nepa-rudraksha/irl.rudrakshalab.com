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

    public function DeselectOrder($skuNo,$referenceNo,$orderId){
                $record = IrlReport::where('SKU_no', $skuNo)
            ->where('reference_no', $referenceNo)
            ->where('order_id', $orderId)
            ->first();

        if (!$record) 
        {

            return 'No matching record found.';

        }

        $record->order_id   = null;

        $record->name       = null;

        $record->phone      = null;

        $record->email      = null;

        $record->created_by = null;

        $record->save();

        return 'Fields deselected successfully.';

    }
}

