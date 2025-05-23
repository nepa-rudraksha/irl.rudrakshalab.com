<?php

namespace App\Services\IRLServices;

use App\Interfaces\IRLInterfaces\IrlPdfStoreServiceInterface;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class IrlPdfStoreService implements IrlPdfStoreServiceInterface{
    public function savePDFAuto($skuNo,$referenceNo,$pdf)
    {
        try 

        {

            $filename = (string) Str::uuid() . '_' . $referenceNo . '.' . $pdf->getClientOriginalExtension();

            $pdf->storeAs('report', $filename,'public'); // You can also specify disk: ->storeAs('report', $filename, 'public');

            $url = Storage::disk('public')->url('report/' . $filename);

            return [
                'filename' => $filename,
                'url' => $url,
            ];

        } 

        catch (\Exception $ex) 

        {

            Log::error('PDF Upload Error', [
                'reference_no' => $referenceNo,
                'SKU_no'       => $skuNo,
                'error'        => $ex->getMessage()
            ]);

            return '❌ Something went wrong while uploading the PDF.';

        }
    }
    public function savePDFTemp($order_no,$pdf){
        try
        {
          $url = "";
          $filename = (string) Str::uuid() . '.' . $pdf->getClientOriginalExtension();
          $pdf->storeAs('report', $filename,'public'); 
          $url = Storage::disk('public')->url('report/' . $filename);
          return [
            'url' => $url,
          ];
        }
        catch (\Exception $ex) 
        {

            Log::error('PDF Upload Error', [
                'url' => $url,
                'error'        => $ex->getMessage()
            ]);

            return '❌ Something went wrong while uploading the PDF.';

        }
    }
}