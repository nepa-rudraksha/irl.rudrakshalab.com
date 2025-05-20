<?php
namespace App\Services\IRLServices;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\IrlReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class IrlPdfService{
    protected $order_id="";
        public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf,string $order_id)
    {
    // Step 1: Match SKU and reference_no in DB
        $record = IrlReport::where('SKU_no', $skuNo)
                    ->where('reference_no', $referenceNo)
                    ->first();
            $this->order_id = $record->order_id??$order_id??"";
        if (!$record) {
            return $this->savePDFTemp($order_id,$pdf);;
        }

        // Step 2: Store PDF
        try {
            $filename = (string) Str::uuid() . '_' . $referenceNo . '.' . $pdf->getClientOriginalExtension();
            $pdf->storeAs('report', $filename,'public'); // You can also specify disk: ->storeAs('report', $filename, 'public')

            // Step 3: Save PDF path in DB
            $record->pdf_url = $filename;

            $record->save();
        $url = Storage::disk('public')->url('report/' . $filename);
            return $url;
        } catch (\Exception $ex) {
            Log::error('PDF Upload Error', [
                'reference_no' => $referenceNo,
                'SKU_no'       => $skuNo,
                'error'        => $ex->getMessage()
            ]);
            return '❌ Something went wrong while uploading the PDF.';
        }
    }


    function savePDFTemp($order_no,$pdf){
    $url = "";
    // Step 2: Store PDF
    try {
        $filename = (string) Str::uuid() . '.' . $pdf->getClientOriginalExtension();

        $pdf->storeAs('report', $filename,'public'); // You can also specify disk: ->storeAs('report', $filename, 'public')
        $url = Storage::disk('public')->url('report/' . $filename);


        return $url;
    } catch (\Exception $ex) {
        Log::error('PDF Upload Error', [
            'url' => $url,
            'error'        => $ex->getMessage()
        ]);
        return '❌ Something went wrong while uploading the PDF.';
    }
}

function getOrderId(){
    return $this->order_id;
}


}