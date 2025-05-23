<?php
namespace App\Interfaces\IRLInterfaces;

use Illuminate\Http\UploadedFile;

interface IrlPdfInterface{
    public function savePDF($request);
}