<?php

namespace App\Services\IRLServices;

use App\Models\IrlReport;

use App\Interfaces\IRLInterfaces\IrlOrderDetailInterface;
use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;


class IrlOrderDetailService implements IrlOrderDetailInterface

{

    protected $reference_no="";

    protected $email="";

    protected $SKU_no="";

    protected IrlReportRepositoryInterface $irlReportRepositoryService;

    public function __construct(IrlReportRepositoryInterface $irlReportRepositoryService)
    {
        $this->irlReportRepositoryService= $irlReportRepositoryService;
    }

    public function saveOrderDetail($request)

    {
        try{
             $payload = $request->all();

                if (isset($payload['SKU_no'])) 
                {   

                    $payload = [$payload];

                }

                Log::info("reference log:",['payload' => $payload]);

                $results = [];

                foreach ($payload as $skuData) 
                {

                    // 🔁 Create a new Request instance with current item’s data
                    $skuRequest = new Request($skuData);

                    Log::info("reference log:",['skuRequest' => $skuRequest]);

                    // 🧠 Reuse existing saveOrderDetail logic
                    // Check if this is an update to existing SKU

                     if ($skuRequest->filled('reference_no')) 

                    {
                        $order = $this->irlReportRepositoryService->findBySkuAndReference($skuRequest->SKU_no,$skuRequest->reference_no);

                        if(!$order)

                        {

                            throw new \Exception("Reference Number for SKU Number: " . $skuRequest->SKU_no . " doesn't match.");

                        }

                    }

                    else 

                    {

                        $order = $this->irlReportRepositoryService->findBySku($skuRequest->SKU_no);

                    }

                    // If not found, create a new instance
                    if (!$order) 

                    {
                        Log::info("order fail:",['order'=>$order]);
                        $order = $this->irlReportRepositoryService->MapNewReferenceNumber($skuRequest->SKU_no);
                    }

                    // Case 1: Only SKU_no received (initial creation)
                    if (
                        !$skuRequest->name &&
                        !$skuRequest->email  &&
                        !$skuRequest->created_by && !$skuRequest->order_id
                        ) 

                    {

                        Log::info("sku only order:",['order'=>$order]);

                        $this->irlReportRepositoryService->saveSkuMapping($order);

                        $reference_no = $order->reference_no;
                    
                    }

                    // Case 2: Full data received — must validate ALL required fields
                    if (
                        $skuRequest->name &&   
                        $skuRequest->email &&
                        $skuRequest->created_by && $skuRequest->order_id
                        ) 

                    {           
                        Log::info("whole data order:",['order'=>$order]);

                        $this->irlReportRepositoryService->saveOrderDetails($order,$skuRequest->name,$skuRequest->email,$skuRequest->created_by,$skuRequest->order_id);

                        $reference_no = $skuRequest->reference_no??$order->reference_no;

                    }


                    $results[] = 
                    [

                        'SKU_no' => $skuData['SKU_no'],

                        'reference_no' => $reference_no,

                        'message' => "Order Saved Successfully"

                    ];

                }
                return [
                    "status" => 200,
                    "message" => "Bulk SKU processing completed.",
                    "response" => $results,
                ];
            }
            catch (Exception $e) 
            {

                Log::error('Bulk order processing failed', ['error' => $e->getMessage()]);

                return 
                    [

                    "status" => 500,

                    "message" => "Bulk order processing failed.",

                    'response' => $e->getMessage(),

                    ];

            }


        // Case 3: Partial data — reject
                return 
                [

                "status" => 500,

                "message" => "Incomplete data. Please send all of name, phone, email, and created_by together.",

                'response' => "",

                ];

    }


    public function deselectOrderDetail($request)

    {
        try{
        $skuNo   = $request->input('SKU_no');

        $irlNo   = $request->input('reference_no');

        $orderId = $request->input('order_id');

        $message = $this->irlReportRepositoryService->DeselectOrder($skuNo,$irlNo,$orderId);
        return [
            'status' => 200,
            'message' => $message,
            'success' => true,
            
        ];
        }
            catch (\Exception $e) 
        
        {

            Log::error('❌ Error in deleteOrderDetail', ['error' => $e->getMessage(),]);

            return 

                [
                'status' => 500,

                'success' => false,

                'message' => 'An error occurred while deselecting order detail.',

                ];

        }
    }

}




    ?>