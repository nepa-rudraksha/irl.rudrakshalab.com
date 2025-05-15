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
public function savePDF(Request $request)
{
    try {
        // Determine how many items were submitted
        $referenceNos = $request->input('reference_no');
        $skuNos       = $request->input('SKU_no');
        $pdfs         = $request->file('pdf');

        $count = is_array($referenceNos) ? count($referenceNos) : 0;

        $responses = [];

        for ($i = 0; $i < $count; $i++) {
            $referenceNo = $request->input("reference_no.$i");
            $skuNo       = $request->input("SKU_no.$i");
            $pdf         = $request->file("pdf.$i");

            Log::info("📦 Processing item #$i", [
                'reference_no' => $referenceNo,
                'sku_no'       => $skuNo,
                'has_pdf'      => $pdf !== null,
            ]);

            if (!$referenceNo || !$skuNo || !$pdf) {
                Log::warning("⚠️ Missing data for item #$i. Skipping.");
                continue;
            }

            $message = $this->irlOrderDetailService->savePDF($referenceNo, $skuNo, $pdf);

            $responses[] = [
                'reference_no' => $referenceNo,
                'sku_no'       => $skuNo,
                'message'      => $message,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk PDF processed successfully.',
            'data' => $responses,
        ], 200);

    } catch (Exception $e) {
        Log::error('❌ Error processing bulk PDF upload', [
            'message' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Error occurred while processing PDFs.',
            'error' => $e->getMessage(),
        ], 500);
    }
}



public function storeBulkOrder(Request $request)
{
    try {
        $payload = $request->all();

        // ✅ Normalize input to array of objects
        if (isset($payload['SKU_no'])) {
            // Single object like {"SKU_no":"D100"} => wrap into array
            $payload = [$payload];
        } elseif (array_keys($payload) === range(0, count($payload) - 1)) {
            // It's already a sequential array — do nothing
        } else {
            // Convert numeric-keyed object to array
            $payload = array_values($payload);
        }

        Log::info("reference log: payload normalized", ['payload' => $payload]);

        $results = [];

        foreach ($payload as $skuData) {
            // 🔁 Create a new Request instance with current item’s data
            $skuRequest = new Request($skuData);

            // 🧠 Reuse existing saveOrderDetail logic
            $message = $this->irlOrderDetailService->saveOrderDetail($skuRequest);
            $reference_no = $this->irlOrderDetailService->getReferenceNo();

            $results[] = [
                'SKU_no' => $skuData['SKU_no'] ?? null,
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

//     public function storePDF(Request $request){
// {
//     try {
//         $payload = $request->all();

//         // Normalize single item to array
//         if (isset($payload['SKU_no']) && isset($payload['pdf'])) {
//             $payload = [$payload];
//         }

//         $results = [];

//         foreach ($payload as $index => $item) {
//             // Check for required fields
//             if (!isset($item['SKU_no'], $item['reference_no'], $item['pdf'])) {
//                 $results[] = [
//                     'index' => $index,
//                     'status' => 'error',
//                     'message' => 'Missing SKU_no, reference_no or PDF file'
//                 ];
//                 continue;
//             }

//             // Create a mock request object to pass to service
//             $itemRequest = new Request([
//                 'SKU_no' => $item['SKU_no'],
//                 'reference_no' => $item['reference_no'],
//             ]);

//             // Attach the file manually
//             $itemRequest->files->set('pdf', $item['pdf']);

//             // Call service method
//             $message = $this->irlOrderDetailService->savePDF($itemRequest);

//             $results[] = [
//                 'index' => $index,
//                 'SKU_no' => $item['SKU_no'],
//                 'reference_no' => $item['reference_no'],
//                 'status' => 'success',
//                 'message' => $message
//             ];
//         }

//         return response()->json([
//             'message' => 'PDF processing complete.',
//             'results' => $results
//         ], 200);

//     } catch (\Exception $e) {
//         Log::error('Bulk PDF Store Failed', ['error' => $e->getMessage()]);

//         return response()->json([
//             'message' => 'PDF upload failed.',
//             'success' => false,
//             'error' => $e->getMessage()
//         ], 500);
//     }
//     }

// }
}