<?php

namespace App\Interfaces\IRLInterfaces;

interface IrlPdfDBSaveServiceInterface{
    public function savePdfDB($fileName,$record);
}