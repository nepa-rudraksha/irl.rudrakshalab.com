<?php
namespace App\Services\IRLServices;

use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;

use App\Interfaces\IRLInterfaces\IrlPdfInterface;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

use Illuminate\Http\UploadedFile;

class IrlPdfService implements IrlPdfInterface
{

    protected $order_id="";
    protected IrlReportRepositoryInterface $irlReportRepositoryService;

    public function __construct(IrlReportRepositoryInterface $irlReportRepositoryService)
    {
        $this->irlReportRepositoryService = $irlReportRepositoryService;
    }

    public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf,string $order_id)
    {

    // Step 1: Match SKU and reference_no in DB
        $record = $this->irlReportRepositoryService->findBySkuAndReference($skuNo,$referenceNo);

        $this->order_id = $record->order_id??$order_id??"";

        if (!$record) 

        {

            return $this->savePDFTemp($order_id,$pdf);

        }

        // Step 2: Store PDF
        try 

        {

            $filename = (string) Str::uuid() . '_' . $referenceNo . '.' . $pdf->getClientOriginalExtension();

            $pdf->storeAs('report', $filename,'public'); // You can also specify disk: ->storeAs('report', $filename, 'public')

            // Step 3: Save PDF path in DB
            $record->pdf_url = $filename;

            $record->save();

            $url = Storage::disk('public')->url('report/' . $filename);

            return $url;

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


    function savePDFTemp($order_no,$pdf)
    {
        $url = "";

        // Step 2: Store PDF
        try 

        {

            $filename = (string) Str::uuid() . '.' . $pdf->getClientOriginalExtension();

            $pdf->storeAs('report', $filename,'public'); // You can also specify disk: ->storeAs('report', $filename, 'public')

            $url = Storage::disk('public')->url('report/' . $filename);

            return $url;

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


    function getOrderId()
    {

        return $this->order_id;

    }


}