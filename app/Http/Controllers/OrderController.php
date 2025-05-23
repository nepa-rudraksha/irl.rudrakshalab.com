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
        $results = $this->irlOrderDetailService->saveOrderDetail($request);

                return response()->json
                (
                    [

                    'message' => $results['message'],

                    'data' => $results['response'],

                    ]

                    , $results['status']

                );

        }

        }
