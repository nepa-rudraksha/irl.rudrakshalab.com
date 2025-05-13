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



        $message = $this->irlOrderDetailService->saveOrderDetail($request);

        $reference_no = $this->irlOrderDetailService->getReferenceNo();
        

Log::info("reference log:", [
    'reference_no' => $request->input('reference_no'),
    'SKU_no' => $request->input('SKU_no'),
    'has_pdf' => $request->hasFile('pdf')
]);


        ob_clean();

                Log::info("reference failes2:",['reference_no'=>$reference_no]);

        return response()->json(

            [

                'message' => $message,

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

    function savePDF(Request $request){
        try{
Log::info("reference log:", [
    'reference_no' => $request->input('reference_no'),
    'SKU_no' => $request->input('SKU_no'),
    'has_pdf' => $request->hasFile('pdf')
]);
        $message = $this->irlOrderDetailService->savePDF($request);
               Log::info("reference log:",['reference_no'=>$request]);
               
        ob_clean();
                return response()->json(

            [

                'message' => $message,

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


public function storeBulkOrder(Request $request)
{
    try {
        $payload = $request->all();
                if (isset($payload['SKU_no'])) {
                                   Log::info("reference log:",['payload' => $payload]);
            $payload = [$payload];
        }

        $results = [];

        foreach ($payload as $skuData) {
            // 🔁 Create a new Request instance with current item’s data
            $skuRequest = new Request($skuData);

            // 🧠 Reuse existing saveOrderDetail logic
            $message = $this->irlOrderDetailService->saveOrderDetail($skuRequest);
            $reference_no = $this->irlOrderDetailService->getReferenceNo();

            $results[] = [
                'SKU_no' => $skuData['SKU_no'],
                'reference_no' => $reference_no,
                'message' => $message
            ];
        }

        return response()->json([
            'message' => 'Bulk SKU processing completed.',
            'data' => $results,
        ], 200);
    } catch (Exception $e) {
        Log::error('Bulk order processing failed', ['error' => $e->getMessage()]);

        return response()->json([
            'message' => 'Bulk processing error',
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

    public function storePDF(Request $request){
{
    try {
        $payload = $request->all();

        // Normalize single item to array
        if (isset($payload['SKU_no']) && isset($payload['pdf'])) {
            $payload = [$payload];
        }

        $results = [];

        foreach ($payload as $index => $item) {
            // Check for required fields
            if (!isset($item['SKU_no'], $item['reference_no'], $item['pdf'])) {
                $results[] = [
                    'index' => $index,
                    'status' => 'error',
                    'message' => 'Missing SKU_no, reference_no or PDF file'
                ];
                continue;
            }

            // Create a mock request object to pass to service
            $itemRequest = new Request([
                'SKU_no' => $item['SKU_no'],
                'reference_no' => $item['reference_no'],
            ]);

            // Attach the file manually
            $itemRequest->files->set('pdf', $item['pdf']);

            // Call service method
            $message = $this->irlOrderDetailService->savePDF($itemRequest);

            $results[] = [
                'index' => $index,
                'SKU_no' => $item['SKU_no'],
                'reference_no' => $item['reference_no'],
                'status' => 'success',
                'message' => $message
            ];
        }

        return response()->json([
            'message' => 'PDF processing complete.',
            'results' => $results
        ], 200);

    } catch (\Exception $e) {
        Log::error('Bulk PDF Store Failed', ['error' => $e->getMessage()]);

        return response()->json([
            'message' => 'PDF upload failed.',
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
    }

}
}