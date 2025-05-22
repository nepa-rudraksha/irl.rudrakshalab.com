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

    try 
    {

        $referenceNos = $request->input('reference_no')??"";

        $skuNos       = $request->input('SKU_no')??"";

        $pdfs         = $request->file('pdf');

        $order_ids  = $request->input('order_id')??"";

        // Determine if it's a bulk array or a single file upload
        if (is_array($pdfs)) 
        {

            $count = count($pdfs);

            for ($i = 0; $i < $count; $i++) 
            {

                $referenceNo = $request->input("reference_no.$i")??"";

                $skuNo       = $request->input("SKU_no.$i")??"";

                $pdf         = $request->file("pdf.$i");

                $order_id   = $request->order_id??"";


                Log::info
                (
                    "📦 Processing item #$i", 
                    [

                    'reference_no' => $referenceNo??"",

                    'sku_no'       => $skuNo??"",

                    'has_pdf'      => $pdf !== null,

                    ]
                );

                if (!$pdf) 
                {

                    Log::warning("⚠️ Missing data for item #$i. Skipping.");

                    continue;

                }

                $MetaData = $this->irlPdfService->savePDF($referenceNo, $skuNo, $pdf,$order_id);

                $responses[] = 
                [

                    'order_id' => $MetaData['order_id'],

                    'url' => $MetaData['url'],

                    'message'      => "PDF processed successfully.",

                ];

            }

        } 

        return response()->json
        (
            [

            'success' => true,

            'message' => 'PDF(s) processed successfully.',

            'data' => $responses,

            ]
            , 200
        );

    } 
    catch (Exception $e) 
    {

        Log::error

        (

            '❌ Error processing PDF upload', 

            [

            'message' => $e->getMessage(),

            ]

        );

        return response()->json
        
        (
            
            [

            'success' => false,

            'message' => 'Error occurred while processing PDFs.',

            'error' => $e->getMessage(),

            ]
        
            , 500
    
        );
    }

}


    public function deleteOrderDetail(Request $request)

    {

        try 
        
        {

            $message = $this->irlOrderDetailService->deselectOrderDetail($request);

            return response()->json
            (

                [

                'success' => true,

                'message' => $message,

                ]

            );

        }
        
        catch (\Exception $e) 
        
        {

            Log::error
            (
                '❌ Error in deleteOrderDetail', 

                [

                'error' => $e->getMessage(),

                ]);

            return response()->json

            (

                [

                'success' => false,

                'message' => 'An error occurred while deselecting order detail.',

                ]

                , 500

            );

        }

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