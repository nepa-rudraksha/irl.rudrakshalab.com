<?php
namespace App\Services\IRLServices;

use App\Interfaces\IRLInterfaces\IrlPdfDBSaveServiceInterface;
use Illuminate\Support\Facades\Log;

class IrlPdfDBSaveService implements IrlPdfDBSaveServiceInterface{
    public function savePDFDB($filename, $record){
        try{
        $record->pdf_url = $filename;
        $record->save();
        }

        catch (\Exception $ex) 

        {

            Log::error('PDF Upload Error', [
                'record' => $record,
                'filename'       => $filename,
                'error'        => $ex->getMessage()
            ]);

            return '❌ Something went wrong while uploading the PDF.';

        }

    }
}