<?php

namespace App\Services\IRLServices;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\IrlReport;

use Exception;

use App\Interfaces\IRLInterfaces\IrlQrInterface;





class IrlQrService implements IrlQrInterface{

    public function publishOrder($reference_no){

        try {

            // Attempt to retrieve the record

            $irlReport = IrlReport::where('reference_no', $reference_no)->first();

            // Check if the record exists

            if (!$irlReport) {

                throw new ModelNotFoundException("No record found with reference number: {$reference_no}");

            }



            // Update the status

            $irlReport->status = IrlReport::PUBLISHED;

            // if($irlReport->pdf_url != null){

            // if (!$irlReport->save()) {

            //     throw new \Exception("Failed to update the status for reference number: {$reference_no}");

            // }



        

            // return response()->json(['message' => 'Status updated successfully!'], 200);

            // }

            // else{

            //     echo "failed to update qr";

            // }

            $irlReport->save();

            return "Status updated successfully!";

        } catch (ModelNotFoundException $e) {

            return response()->json(['error' => $e->getMessage()], 404);

        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);

        }

    }



}

?>