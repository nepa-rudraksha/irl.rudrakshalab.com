<?php
namespace App\Repositories;

use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;
use App\Models\IrlReport;
use Illuminate\Support\Facades\Log;

class IrlReportRepository implements IrlReportRepositoryInterface{
    public function findBySkuAndReference(string $skuNo,string $referenceNo){

        return IrlReport::where('SKU_no', $skuNo)
                ->where('reference_no', $referenceNo)
                ->first();

    }

    public function findBySku(string $skuNo){

        return IrlReport::where('SKU_no', $skuNo)->first();

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

    public function getNewReferenceNumber(){

        return IrlReport::getNextReferenceNo();

    }

    public function MapNewReferenceNumber($skuNo){


            $order = new IrlReport();

            $order->SKU_no = $skuNo;

            $order->reference_no = $this->getNewReferenceNumber();

            return $order;
    }

    public function saveSkuMapping($order)
    {
            $order->status = IrlReport::PUBLISHED;

            $order->created_at = $order->created_at??now();

            $order->save();

    }
    

    public function saveOrderDetails($order,$name,$email,$created_by,$order_id)
    {
            $order->name       = $name;

            $order->phone      = $phone??null;

            $order->email      = $email;

            $order->order_id    = $order_id;

            $order->status = IrlReport::PUBLISHED;

            $order->created_by = $created_by;

            $order->created_at = now();

            $order->save();
    }
}

