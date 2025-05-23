<?php

namespace App\Interfaces\IRLInterfaces;

interface IrlReportRepositoryInterface{
    public function findBySkuAndReference(string $skuNo,string $referenceNo);
    public function DeselectOrder($skuNo,$referenceNo,$orderId);
    public function findBySku(string $skuNo);
    public function getNewReferenceNumber();
    public function MapNewReferenceNumber($skuNo);
    public function saveSkuMapping($order);
    public function saveOrderDetails($order,$name,$email,$created_by,$order_id);
}