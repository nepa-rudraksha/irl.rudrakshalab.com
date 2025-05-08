<?php

namespace App\Http\Controllers;



use App\Services\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Http\Request;

use App\Services\IRLInterfaces\IrlQrInterface;

use Illuminate\Support\Facades\Log;

use Exception;



class OrderController extends Controller

{

    protected IrlQrInterface $irlQrService;

    protected IrlOrderDetailInterface $irlOrderDetailService;

    public function __construct(IrlQrInterface $irlQrService,IrlOrderDetailInterface $irlOrderDetailService)

    {

        $this->irlQrService = $irlQrService;

        $this->irlOrderDetailService = $irlOrderDetailService;



    }

    public function storeOrder(Request $request)

    {

        

        try{



        $this->irlOrderDetailService->saveOrderDetail($request);

        $reference_no = $this->irlOrderDetailService->getReferenceNo();

        Log::info("img fails:",['reference_no'=>$reference_no]);

        $img = $this->irlOrderDetailService->getQrImg();

        Log::info("reference failes:",['reference_no'=>$reference_no]);

        ob_clean();

                Log::info("reference failes2:",['reference_no'=>$reference_no]);

        return response()->json(

            [

                'message' => 'Order created successfully!',

                'img'=>$img,

                'reference_no'=>$reference_no,

            ]

            , 200);

        }

        catch(Exception $e){

            Log::error('Error sending data to API', ['message' => $e->getMessage()]);



            return response()->json([

                'message' => 'An error occurred while sending data.',

                'success' => false,

                'error' => $e->getMessage(),

            ], 500);

        }

    }

    function storeOrderTest(Request $request){
        return response()->json(

            [

                'message' => 'Order created successfully!',
                'reference_no'=>'20302139002',

            ]

            , 200);

        }
    
    public function publishOrder(Request $request)

    {

        $reference_no = $request->reference_no;

        return response()->json(['message' => $this->irlQrService->publishOrder($reference_no)], 200);

    }

    public function storePDF(){

        

    }

}