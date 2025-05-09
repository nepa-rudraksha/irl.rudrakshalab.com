<?php

namespace App\Services\IRLServices;

use App\Models\IrlReport;

use Carbon\Carbon;

use App\Services\IRLInterfaces\IrlOrderDetailInterface;

use Illuminate\Support\Facades\Crypt;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Log;


class IrlOrderDetailService implements IrlOrderDetailInterface

{

    protected $reference_no="";

    protected $email="";
    protected $SKU_no="";

    

    public function saveOrderDetail($request)
    {
        
        // Check if this is an update to existing SKU
        $order = IrlReport::where('SKU_no', $request->SKU_no)->first();
        Log::info("order:",['order'=>$order]);
        // If not found, create a new instance
        if (!$order) {
            Log::info("order fail:",['order'=>$order]);
            $order = new IrlReport();
            $order->SKU_no = $request->SKU_no;
            $order->reference_no = IrlReport::getNextReferenceNo();
        }
    
        // Case 1: Only SKU_no received (initial creation)
        if (
            !$request->name && !$request->phone &&
            !$request->email && !$request->user_id &&
            !$request->created_by
        ) {
            Log::info("sku only order:",['order'=>$order]);
            $order->status = IrlReport::DRAFT;
            $order->created_at = now();
            $order->save();
            return "SKU stored successfully.";
        }
    
        // Case 2: Full data received — must validate ALL required fields
        if (
            $request->name && $request->phone &&
            $request->email && $request->user_id &&
            $request->created_by
        ) {
            Log::info("whole data order:",['order'=>$order]);
            $order->name       = $request->name;
            $order->phone      = $request->phone;
            $order->email      = $request->email;
            $order->user_id    = $request->user_id;
            $order->created_by = $request->created_by;
            $order->status     = IrlReport::PUBLISHED;
            $order->created_at = now();
            $order->save();
            return "Order saved successfully.";
        }
    
        // Case 3: Partial data — reject
        return "Incomplete data. Please send all of name, phone, email, user_id, and created_by together.";
    }
    


    public function getReferenceNo()

    {

        return $this->reference_no;

    }

    public function getSkuNo(){
        return $this->SKU_no;
    }

    public function getQrImg(){

        Log::info("img fails:",['reference_no'=>$this->reference_no]);

        $encryptedString = Crypt::encryptString("{$this->reference_no}|{$this->email}");

        $qrcode = QrCode::size(200)->format('png')->generate('https://irl.rudrakshalab.com/validate-report/' . $encryptedString);



        return base64_encode((string) $qrcode);

        

    }

}



?>