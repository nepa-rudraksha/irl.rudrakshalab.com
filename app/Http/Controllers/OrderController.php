<?php

namespace App\Http\Controllers;


use App\Interfaces\IRLInterfaces\IrlOrderDetailInterface;

use App\Interfaces\IRLInterfaces\IrlPdfInterface;

use Illuminate\Http\Request;

use App\Interfaces\IRLInterfaces\IrlQrInterface;

use Illuminate\Support\Facades\Log;

use Exception;


class OrderController extends Controller

{

    protected IrlQrInterface $irlQrService;

    protected IrlOrderDetailInterface $irlOrderDetailService;

    protected IrlPdfInterface $irlPdfService;

    public function __construct(IrlQrInterface $irlQrService,IrlOrderDetailInterface $irlOrderDetailService,IrlPdfInterface $irlPdfService)

    {

        $this->irlQrService = $irlQrService;

        $this->irlOrderDetailService = $irlOrderDetailService;

        $this->irlPdfService = $irlPdfService;
    }
    public function savePDF(Request $request)
    {
        $Metadata = $this->irlPdfService->savePDF($request);
        return response()->json
        (
            [

            'success' => $Metadata['sign'],

            'message' => $Metadata['message'],

            'data' => $Metadata['responses'],

            ]
            , $Metadata['status']
        );

   
}


    public function deleteOrderDetail(Request $request)

    {

            $MetaData = $this->irlOrderDetailService->deselectOrderDetail($request);

            return response()->json
            (

                [

                'success' => $MetaData['success'],

                'message' => $MetaData['message'],

                ]
                , $MetaData['status']

            );

        }
        



    public function storeBulkOrder(Request $request)
    {

        try {

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
                    $message = $this->irlOrderDetailService->saveOrderDetail($skuRequest);

                    $reference_no = $this->irlOrderDetailService->getReferenceNo();

                    $results[] = 
                    [

                        'SKU_no' => $skuData['SKU_no'],

                        'reference_no' => $reference_no,

                        'message' => $message

                    ];

                }

                return response()->json
                (
                    [

                    'message' => 'Bulk SKU processing completed.',

                    'data' => $results,

                    ]

                    , 200

                );

        }
        catch (Exception $e) 
        {

            Log::error('Bulk order processing failed', ['error' => $e->getMessage()]);

            return response()->json
            (
                [

                'message' => 'Bulk processing error',

                'success' => false,

                'error' => $e->getMessage(),

                ]

                , 500
                
            );

        }

        }

    }