<?php
namespace App\Services\IRLServices;

use App\Interfaces\IRLInterfaces\IrlPdfDBSaveServiceInterface;
use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;

use App\Interfaces\IRLInterfaces\IrlPdfInterface;
use App\Interfaces\IRLInterfaces\IrlPdfStoreServiceInterface;

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

    public function savePDF(string $referenceNo, string $skuNo, UploadedFile $pdf,string $order_id)
    {

    // Step 1: Match SKU and reference_no in DB
        $record = $this->irlReportRepositoryService->findBySkuAndReference($skuNo,$referenceNo);

        $order_id = $record->order_id??$order_id??"";

        if (!$record) 

        {

            $url = $this->irlPdfStoreService->savePDFTemp($order_id,$pdf);
        return [
            'url' => $url,
            'order_id' => $order_id,
        ];
        }
   
        $MetaData = $this->irlPdfStoreService->savePDFAuto($skuNo,$referenceNo,$pdf);
        $this->irlPdfDBSaveService->savePDFDB($MetaData['filename'],$record);
        return [
            'url' => $MetaData['url'],
            'order_id' => $order_id,
        ];
    }
}