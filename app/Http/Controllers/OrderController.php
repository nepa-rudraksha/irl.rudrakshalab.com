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
function PDFTemp($request){
    try {
    $order_no = $request->input('order_no');
    $pdfs   = $request->file('pdf');

    $responses = [];

    // Determine if it's a bulk array or a single file upload
    if (is_array($order_no)) {
        $count = count($order_no);

        for ($i = 0; $i < $count; $i) {
            $order_nos = $request->input("order_no.$i");
            $pdfs         = $request->file("pdf.$i");

            Log::info("📦 Processing item #$i", [
                'order_no' => $order_nos,
                'has_pdf'      => $pdfs !== null,
            ]);

            if (!$order_nos || !$pdfs) {
                Log::warning("⚠️ Missing data for item #$i. Skipping.");
                continue;
            }

            $url = $this->irlOrderDetailService->savePDFTemp($order_nos, $pdfs);

            $responses[] = [
                'reference_no' => $order_nos,
                'url' => $url,
            ];
        }
    } else {
        // Handle single item
        $referenceNo = $request->input('reference_no');
        $skuNo       = $request->input('SKU_no');
        $pdf         = $request->file('pdf');

        Log::info("📦 Processing single item", [
            'reference_no' => $referenceNo,
            'sku_no'       => $skuNo,
            'has_pdf'      => $pdf !== null,
        ]);

        if (!$referenceNo || !$skuNo || !$pdf) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields.',
            ], 422);
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
        'message' => 'PDF(s) processed successfully.',
        'data' => $responses,
    ], 200);

} catch (Exception $e) {
    Log::error('❌ Error processing PDF upload', [
        'message' => $e->getMessage(),
    ]);

    return response()->json([
        'success' => false,
        'message' => 'Error occurred while processing PDFs.',
        'error' => $e->getMessage(),
    ], 500);
}
 }

public function savePDF(Request $request)
{
try {
    $referenceNos = $request->input('reference_no');
    $skuNos       = $request->input('SKU_no');
    $pdfs         = $request->file('pdf');

    $responses = [];

    // Determine if it's a bulk array or a single file upload
    if (is_array($referenceNos)) {
        $count = count($referenceNos);

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
    } else {
        // Handle single item
        $referenceNo = $request->input('reference_no');
        $skuNo       = $request->input('SKU_no');
        $pdf         = $request->file('pdf');

        Log::info("📦 Processing single item", [
            'reference_no' => $referenceNo,
            'sku_no'       => $skuNo,
            'has_pdf'      => $pdf !== null,
        ]);

        if (!$referenceNo || !$skuNo || !$pdf) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields.',
            ], 422);
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
        'message' => 'PDF(s) processed successfully.',
        'data' => $responses,
    ], 200);

} catch (Exception $e) {
    Log::error('❌ Error processing PDF upload', [
        'message' => $e->getMessage(),
    ]);

    return response()->json([
        'success' => false,
        'message' => 'Error occurred while processing PDFs.',
        'error' => $e->getMessage(),
    ], 500);
}

}

// App\Services\IRLServices\IrlOrderDetailService.php

// App\Http\Controllers\OrderController.php

public function deleteOrderDetail(Request $request)
{
    try {
        $message = $this->irlOrderDetailService->deselectOrderDetail($request);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    } catch (\Exception $e) {
        Log::error('❌ Error in deleteOrderDetail', [
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while deselecting order detail.',
        ], 500);
    }
}



public function storeBulkOrder(Request $request)
{
    try {
        $payload = $request->all();

                if (isset($payload['SKU_no'])) {

            $payload = [$payload];
        }
            Log::info("reference log:",['payload' => $payload]);
        $results = [];

        foreach ($payload as $skuData) {
            // 🔁 Create a new Request instance with current item’s data
            $skuRequest = new Request($skuData);
            Log::info("reference log:",['skuRequest' => $skuRequest]);
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