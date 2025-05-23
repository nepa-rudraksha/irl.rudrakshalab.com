<?php

namespace App\Services\IRLServices;

use App\Models\IrlReport;

use App\Interfaces\IRLInterfaces\IrlOrderDetailInterface;
use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;
use Illuminate\Support\Facades\Log;


class IrlOrderDetailService implements IrlOrderDetailInterface

{

    protected $reference_no="";

    protected $email="";

    protected $SKU_no="";

    protected IrlReportRepositoryInterface $deselectOrderService;

    public function __construct(IrlReportRepositoryInterface $deselectOrderService)
    {
        $this->deselectOrderService = $deselectOrderService;
    }

    public function saveOrderDetail($request)

    {

        // Check if this is an update to existing SKU
        if ($request->filled('reference_no')) 

        {
            $order = IrlReport::where('SKU_no', $request->SKU_no)
                            ->where('reference_no', $request->reference_no)
                            ->first();

            if(!$order)

            {

                throw new \Exception("Reference Number for SKU Number: " . $request->SKU_no . " doesn't match.");

            }

        }

        else 

        {

            $order = IrlReport::where('SKU_no', $request->SKU_no)->first();

        }

        // If not found, create a new instance
        if (!$order) 

        {

            Log::info("order fail:",['order'=>$order]);

            $order = new IrlReport();

            $order->SKU_no = $request->SKU_no;

            $order->reference_no = IrlReport::getNextReferenceNo();

            $this->reference_no = $order->reference_no;

            $this->SKU_no = $request->SKU_no;

        }

        // Case 1: Only SKU_no received (initial creation)
        if (
            !$request->name &&
            !$request->email  &&
            !$request->created_by && !$request->order_id
            ) 

        {

            Log::info("sku only order:",['order'=>$order]);

            $order->status = IrlReport::PUBLISHED;

            $order->created_at = $order->created_at??now();

            $this->reference_no = $order->reference_no;

            $order->save();

            return "SKU stored successfully.";

        }

        // Case 2: Full data received — must validate ALL required fields
        if (
            $request->name &&
            $request->email &&
            $request->created_by && $request->order_id
            ) 

        {

            Log::info("whole data order:",['order'=>$order]);

            $order->name       = $request->name;

            $order->phone      = $request->phone;

            $order->email      = $request->email;

            $order->order_id    = $request->order_id;

            $order->status = IrlReport::PUBLISHED;

            $this->email = $request->email;
            
            $this->reference_no = $request->reference_no??$order->reference_no;

            $order->created_by = $request->created_by;

            $order->created_at = now();

            $order->save();

            return "Order saved successfully.";

        }

        // Case 3: Partial data — reject
        return "Incomplete data. Please send all of name, phone, email, and created_by together.";

    }


    public function deselectOrderDetail($request)

    {
        try{
        $skuNo   = $request->input('SKU_no');

        $irlNo   = $request->input('reference_no');

        $orderId = $request->input('order_id');

        $message = $this->deselectOrderService->DeselectOrder($skuNo,$irlNo,$orderId);
        return [
            'status' => 200,
            'message' => $message,
            'success' => true,
            
        ];
        }
            catch (\Exception $e) 
        
        {

            Log::error
            (
                '❌ Error in deleteOrderDetail', 

                [

                'error' => $e->getMessage(),

                ]);

            return 

                [
                'status' => 500,

                'success' => false,

                'message' => 'An error occurred while deselecting order detail.',

                ];

        }
    }


    public function getReferenceNo()

    {

        return $this->reference_no;

    }

    public function getSkuNo()

    {

        return $this->SKU_no;

    }


    function getEmail(){

        return $this->email;

    }

}




    ?>