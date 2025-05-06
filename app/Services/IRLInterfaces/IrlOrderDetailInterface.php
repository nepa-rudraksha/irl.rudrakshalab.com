<?php
namespace App\Services\IRLInterfaces;
interface IrlOrderDetailInterface{
    public function saveOrderDetail($reference_no);
    public function getReferenceNo();
}
?>