<?php

namespace App\Http\Controllers;



use App\Services\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Http\Request;

use App\Services\IRLInterfaces\IrlQrInterface;

use Illuminate\Support\Facades\Log;

use App\Services\IRLInterfaces\IrlPdfInterface;

use Exception;



class OrderController extends Controller

{

    protected IrlPdfInterface $irlPdfService;

    protected IrlOrderDetailInterface $irlOrderDetailService;

    public function __construct(IrlOrderDetailInterface $irlOrderDetailService, IrlPdfInterface $irlPdfService)

    {

        $this->irlOrderDetailService = $irlOrderDetailService;

        $this->irlPdfService = $irlPdfService;

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
    $referenceNos = $request->input('reference_no')??"";
    $skuNos       = $request->input('SKU_no')??"";
    $pdfs         = $request->file('pdf');
    $order_ids  = $request->input('order_id')??"";

    // Determine if it's a bulk array or a single file upload
    if (is_array($pdfs)) {
        $count = count($pdfs);

        for ($i = 0; $i < $count; $i++) {
            $referenceNo = $request->input("reference_no.$i")??"";
            $skuNo       = $request->input("SKU_no.$i")??"";
            $pdf         = $request->file("pdf.$i");
            $order_id   = $request->order_id??"";


            Log::info("📦 Processing item #$i", [
                'reference_no' => $referenceNo??"",
                'sku_no'       => $skuNo??"",
                'has_pdf'      => $pdf !== null,
            ]);

            if (!$pdf) {
                Log::warning("⚠️ Missing data for item #$i. Skipping.");
                continue;
            }

            $url = $this->irlPdfService->savePDF($referenceNo, $skuNo, $pdf,$order_id);
            $order_id = $this->irlPdfService->getOrderId();

            $responses[] = [
                'order_id' => $order_id,
                'url' => $url,
                'message'      => "PDF processed successfully.",
            ];
        }
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
}