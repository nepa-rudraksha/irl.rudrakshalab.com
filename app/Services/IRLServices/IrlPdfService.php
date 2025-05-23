<?php
namespace App\Services\IRLServices;

use App\Interfaces\IRLInterfaces\IrlPdfDBSaveServiceInterface;
use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;

use App\Interfaces\IRLInterfaces\IrlPdfInterface;
use App\Interfaces\IRLInterfaces\IrlPdfStoreServiceInterface;
use App\Interfaces\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Http\Request;

use App\Interfaces\IRLInterfaces\IrlQrInterface;

use Illuminate\Support\Facades\Log;

use Exception;

use Illuminate\Http\UploadedFile;

class IrlPdfService implements IrlPdfInterface
{
    protected IrlReportRepositoryInterface $irlReportRepositoryService;
    protected IrlPdfStoreServiceInterface $irlPdfStoreService;
    protected IrlPdfDBSaveServiceInterface $irlPdfDBSaveService;

    public function __construct(IrlReportRepositoryInterface $irlReportRepositoryService,IrlPdfStoreServiceInterface $irlPdfStoreService,IrlPdfDBSaveServiceInterface $irlPdfDBSaveService)
    {
        $this->irlReportRepositoryService = $irlReportRepositoryService;
        $this->irlPdfStoreService = $irlPdfStoreService;
        $this->irlPdfDBSaveService = $irlPdfDBSaveService;
    }

    public function savePDF($request)
    {
        try 
        {
            $pdfs         = $request->file('pdf');

            // Determine if it's a bulk array or a single file upload
            if (is_array($pdfs)) 
            {

                $count = count($pdfs);

                for ($i = 0; $i < $count; $i++) 
                {

                    $referenceNo = $request->input("reference_no.$i")??"";

                    $skuNo       = $request->input("SKU_no.$i")??"";

                    $pdf         = $request->file("pdf.$i");

                    $order_id   = $request->order_id??"";


                    Log::info
                    (
                        "📦 Processing item #$i", 
                        [

                        'reference_no' => $referenceNo??"",

                        'sku_no'       => $skuNo??"",

                        'has_pdf'      => $pdf !== null,

                        ]
                    );

                    if (!$pdf) 
                    {

                        Log::warning("⚠️ Missing data for item #$i. Skipping.");

                        continue;

                    }

                    $record = $this->irlReportRepositoryService->findBySkuAndReference($skuNo,$referenceNo);
                    $order_id = $record->order_id??$order_id??"";
                if (!$record) 

                {

                    $MetaData = $this->irlPdfStoreService->savePDFTemp($order_id,$pdf);

                }
                else{

                $MetaData = $this->irlPdfStoreService->savePDFAuto($skuNo,$referenceNo,$pdf);
                $this->irlPdfDBSaveService->savePDFDB($MetaData['filename'],$record);
                }

                    $responses[] = 
                    [

                        'order_id' => $order_id,

                        'url' => $MetaData['url'],

                        'message'      => "PDF processed successfully.",

                    ];

                }

            } 
            return [
                "status" => 200,
                "message" => "PDF(s) processed successfully.",
                "responses" => $responses,
                "sign" => true
            ];
        }
     catch (Exception $e) 
    {

        Log::error

        (

            '❌ Error processing PDF upload', 

            [

            'message' => $e->getMessage(),

            ]

        );

               return [
                "status" => 500,
                "message" => "Error occurred while processing PDFs.",
                "responses" => $responses,
                "sign" => false
            ];

}
}
}