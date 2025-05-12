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


class IrlOrderDetailService implements IrlOrderDetailInterface

{

    protected $reference_no="";

    protected $email="";
    protected $SKU_no="";

    

public function saveOrderDetail($request)
{
    // STEP 1: Validate SKU and order ID mismatch
$existingMismatch = IrlReport::where('SKU_no', $request->SKU_no)
    ->where('order_id', '!=', $request->order_id)
    ->exists();

if ($existingMismatch) {
    return response()->json([
        'message' => 'This SKU number is already used for a different order.',
        'success' => false
    ], 422);
}


    // STEP 2: Check if all optional fields are missing → just SKU & order_id received
    $isOnlySkuProvided = !$request->name && !$request->phone &&
                         !$request->email && !$request->user_id &&
                         !$request->created_by;

    if ($isOnlySkuProvided) {
        $order = new IrlReport();
        $order->SKU_no       = $request->SKU_no;
        $order->order_id     = $request->order_id;
        $order->reference_no = IrlReport::getNextReferenceNo();
        $order->status       = IrlReport::DRAFT;
        $order->created_at   = now();
        $order->save();
        $this->reference_no = $order->reference_no;

        return response()->json([
            'message' => 'SKU stored successfully with new reference_no.',
            'reference_no' => $order->reference_no,
            'success' => true
        ]);
    }

    // STEP 3: All required data present — check if updating existing record
    $hasFullData = $request->name && $request->phone &&
                   $request->email && $request->user_id &&
                   $request->created_by;

    if ($hasFullData) {
        // Look for existing row with matching SKU + order_id + reference_no
        $order = IrlReport::where('SKU_no', $request->SKU_no)
                    ->where('order_id', $request->order_id)
                    ->where('reference_no', $request->reference_no)
                    ->first();

        if ($order) {
            // ✅ UPDATE existing
            $order->name       = $request->name;
            $order->phone      = $request->phone;
            $order->email      = $request->email;
            $order->user_id    = $request->user_id;
            $order->created_by = $request->created_by;
            $order->status     = IrlReport::PUBLISHED;
            $order->save();

            return response()->json([
                'message' => 'Existing certificate updated successfully.',
                'success' => true
            ]);
        } else {
            // ✅ NEW entry (fresh row)
            $order = new IrlReport();
            $order->SKU_no       = $request->SKU_no;
            $order->order_id     = $request->order_id;
            $order->reference_no = IrlReport::getNextReferenceNo();
            $order->name         = $request->name;
            $order->phone        = $request->phone;
            $order->email        = $request->email;
            $order->user_id      = $request->user_id;
            $order->created_by   = $request->created_by;
            $order->status       = IrlReport::PUBLISHED;
            $order->created_at   = now();
            $order->save();

            return response()->json([
                'message' => 'New certificate created successfully.',
                'reference_no' => $order->reference_no,
                'success' => true
            ]);
        }
    }

    // STEP 4: Partial data (invalid)
    return response()->json([
        'message' => 'Incomplete data. Please send all of name, phone, email, user_id, and created_by together.',
        'success' => false
    ], 422);
}

    
public function savePDF($request)
{

    try {
        // Validate the incoming request
        $validated = $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240', // max 10MB
            'reference_no' => 'required|string|exists:irl_reports,reference_no',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }

    try {
        // Store the PDF
        $file = $request->file('pdf');
        $filename = (string) Str::uuid() . $request->input('reference_no') . "." . $request->file('pdf')->extension();
;
        $file->storeAs('report', $filename);

        // Find the related IrlReport
        $report = IrlReport::where('reference_no', $request->reference_no)->first();

        if (!$report) {
            return response()->json([
                'message' => 'Reference number not found.',
                'success' => false,
            ], 404);
        }

        // Update the pdf_url field and save
        $report->pdf_url = $filename;
        $report->save();

        return response()->json([
            'message' => 'PDF uploaded successfully.',
            'success' => true,
            'filename' => $filename,
            'url' => Storage::url("report/{$filename}")
        ]);
    } catch (\Exception $ex) {
        return response()->json([
            'message' => 'Something went wrong while uploading the PDF.',
            'error' => $ex->getMessage(),
            'success' => false
        ], 500);
    }
}

    public function getReferenceNo()

    {

        return $this->reference_no;

    }

    public function getSkuNo(){
        return $this->SKU_no;
    }

    public function getQrImg(){

        Log::info("img fails:",['reference_no'=>$this->reference_no]);

        $encryptedString = Crypt::encryptString("{$this->reference_no}|{$this->email}");

        $qrcode = QrCode::size(200)->format('png')->generate('https://irl.rudrakshalab.com/validate-report/' . $encryptedString);



        return base64_encode((string) $qrcode);

        

    }

}



?>