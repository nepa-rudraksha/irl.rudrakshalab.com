<?php

namespace App\Services\IRLServices;

use App\Models\IrlReport;

use Carbon\Carbon;

use App\Services\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Support\Facades\Crypt;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;


class IrlOrderDetailService implements IrlOrderDetailInterface

{

    protected $reference_no="";

    protected $email="";
    protected $SKU_no="";

    

public function saveOrderDetail($request)
    {

        // Check if this is an update to existing SKU
        if ($request->filled('reference_no')) {
            $order = IrlReport::where('SKU_no', $request->SKU_no)
                            ->where('reference_no', $request->reference_no)
                            ->first();

        } else {
            $order = IrlReport::where('SKU_no', $request->SKU_no)->first();
        }
        // If not found, create a new instance
        if (!$order) {
            Log::info("order fail:",['order'=>$order]);
            $order = new IrlReport();
            $order->SKU_no = $request->SKU_no;
            $order->reference_no = IrlReport::getNextReferenceNo();
            $this->reference_no = $order->reference_no;
            $this->SKU_no = $request->SKU_no;
        }

        // Case 1: Only SKU_no received (initial creation)
        if (
            !$request->name && !$request->phone &&
            !$request->email && !$request->user_id &&
            !$request->created_by
        ) {
            Log::info("sku only order:",['order'=>$order]);
            $order->status = IrlReport::PUBLISHED;
            $order->created_at = $order->created_at??now();
            $this->reference_no = $order->reference_no;
            $order->save();
            return "SKU stored successfully.";
        }

        // Case 2: Full data received — must validate ALL required fields
        if (
            $request->name && $request->phone &&
            $request->email && $request->user_id &&
            $request->created_by
        ) {
            Log::info("whole data order:",['order'=>$order]);
            $order->name       = $request->name;
            $order->phone      = $request->phone;
            $order->email      = $request->email;
            $this->email = $request->email;
            $order->user_id    = $request->user_id;
            $order->created_by = $request->created_by;
            // $order->status     = IrlReport::PUBLISHED;
            $order->created_at = now();
            $order->save();
            return "Order saved successfully.";
        }

        // Case 3: Partial data — reject
        return "Incomplete data. Please send all of name, phone, email, user_id, and created_by together.";
    }

public function storeBulkOrderDetail($request){

}

    
public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf)
{

//     try {
//         // Validate the incoming request
//         $validated = $request->validate([
//             'pdf' => 'required|file|mimes:pdf|max:10240', // max 10MB
//             'reference_no' => 'required|string|exists:irl_reports,reference_no',
//         ]);
//     } catch (\Illuminate\Validation\ValidationException $e) {
//         return response()->json([
//             'message' => 'Validation failed',
//             'errors' => $e->errors(),
//         ], 422);
//     }

//     try {
//         // Store the PDF
//         $file = $request->file('pdf');
//         $filename = (string) Str::uuid() . $request->input('reference_no') . "." . $request->file('pdf')->extension();
// ;
//         $file->storeAs('report', $filename);

//         // Find the related IrlReport
//         $report = IrlReport::where('reference_no', $request->reference_no)->first();

//         if (!$report) {
//             return response()->json([
//                 'message' => 'Reference number not found.',
//                 'success' => false,
//             ], 404);
//         }

//         // Update the pdf_url field and save
//         $report->pdf_url = $filename;
//         $report->save();

//         return response()->json([
//             'message' => 'PDF uploaded successfully.',
//             'success' => true,
//             'filename' => $filename,
//             'url' => Storage::url("report/{$filename}")
//         ]);
//     } catch (\Exception $ex) {
//         return response()->json([
//             'message' => 'Something went wrong while uploading the PDF.',
//             'error' => $ex->getMessage(),
//             'success' => false
//         ], 500);
//     }
  // Step 1: Match SKU and reference_no in DB
    $record = IrlReport::where('SKU_no', $skuNo)
                ->where('reference_no', $referenceNo)
                ->first();

    if (!$record) {
        return '❌ SKU and Reference number do not match or record not found.';
    }

    // Step 2: Store PDF
    try {
        $filename = (string) Str::uuid() . '_' . $referenceNo . '.' . $pdf->getClientOriginalExtension();
        $pdf->storeAs('report', $filename); // You can also specify disk: ->storeAs('report', $filename, 'public')

        // Step 3: Save PDF path in DB
        $record->pdf_url = $filename;
        $record->save();

        return '✅ PDF uploaded and linked successfully.';
    } catch (\Exception $ex) {
        Log::error('PDF Upload Error', [
            'reference_no' => $referenceNo,
            'SKU_no'       => $skuNo,
            'error'        => $ex->getMessage()
        ]);
        return '❌ Something went wrong while uploading the PDF.';
    }
}

// App\Services\IRLServices\IrlOrderDetailService.php

public function deselectOrderDetail($request)
{
    $skuNo   = $request->input('SKU_no');
    $irlNo   = $request->input('irl_no');
    $orderId = $request->input('order_id');

    $record = IrlReport::where('SKU_no', $skuNo)
        ->where('reference_no', $irlNo)
        ->where('order_id', $orderId)
        ->first();

    if (!$record) {
        return 'No matching record found.';
    }

    $record->order_id   = null;
    $record->name       = null;
    $record->phone      = null;
    $record->email      = null;
    $record->created_by = null;
    $record->user_id    = null;
    $record->save();

    return 'Fields deselected successfully.';
}

    public function getReferenceNo()

    {

        return $this->reference_no;

    }

    public function getSkuNo(){
        return $this->SKU_no;
    }

}



?>