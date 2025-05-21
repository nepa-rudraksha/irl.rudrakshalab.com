<?php

namespace App\Services\IRLServices;

use App\Models\IrlReport;

use Carbon\Carbon;

use App\Services\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Support\Facades\Crypt;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;


class IrlOrderDetailService implements IrlOrderDetailInterface

{

    protected $reference_no="";

    protected $email="";

    protected $SKU_no="";

    public function saveOrderDetail($request)

    {

        // Check if this is an update to existing SKU
        if ($request->filled('reference_no')) 

        {
            $order = IrlReport::where('SKU_no', $request->SKU_no)
                            ->where('reference_no', $request->reference_no)
                            ->first();

            if(!$order)

            {

                throw new \Exception("Reference Number for SKU Number: " . $request->SKU_no . " doesn't match.");

            }

        }

        else 

        {

            $order = IrlReport::where('SKU_no', $request->SKU_no)->first();

        }

        // If not found, create a new instance
        if (!$order) 

        {

            Log::info("order fail:",['order'=>$order]);

            $order = new IrlReport();

            $order->SKU_no = $request->SKU_no;

            $order->reference_no = IrlReport::getNextReferenceNo();

            $this->reference_no = $order->reference_no;

            $this->SKU_no = $request->SKU_no;

        }

        // Case 1: Only SKU_no received (initial creation)
        if (
            !$request->name &&
            !$request->email  &&
            !$request->created_by && !$request->order_id
            ) 

        {

            Log::info("sku only order:",['order'=>$order]);

            $order->status = IrlReport::PUBLISHED;

            $order->created_at = $order->created_at??now();

            $this->reference_no = $order->reference_no;

            $order->save();

            return "SKU stored successfully.";

        }

        // Case 2: Full data received — must validate ALL required fields
        if (
            $request->name &&
            $request->email &&
            $request->created_by && $request->order_id
            ) 

        {

            Log::info("whole data order:",['order'=>$order]);

            $order->name       = $request->name;

            $order->phone      = $request->phone;

            $order->email      = $request->email;

            $order->order_id    = $request->order_id;

            $order->status = IrlReport::PUBLISHED;

            $this->email = $request->email;
            
            $this->reference_no = $request->reference_no??$order->reference_no;

            $order->created_by = $request->created_by;

            $order->created_at = now();

            $order->save();

            return "Order saved successfully.";

        }

        // Case 3: Partial data — reject
        return "Incomplete data. Please send all of name, phone, email, and created_by together.";

    }


    public function deselectOrderDetail($request)

    {

        $skuNo   = $request->input('SKU_no');

        $irlNo   = $request->input('reference_no');

        $orderId = $request->input('order_id');

        $record = IrlReport::where('SKU_no', $skuNo)
            ->where('reference_no', $irlNo)
            ->where('order_id', $orderId)
            ->first();

        if (!$record) 
        {

            return 'No matching record found.';

        }

        $record->order_id   = null;

        $record->name       = null;

        $record->phone      = null;

        $record->email      = null;

        $record->created_by = null;

        $record->save();

        return 'Fields deselected successfully.';

    }


    public function getReferenceNo()

    {

        return $this->reference_no;

    }

    public function getSkuNo()

    {

        return $this->SKU_no;

    }


    function getEmail(){

        return $this->email;

    }

}




    ?>