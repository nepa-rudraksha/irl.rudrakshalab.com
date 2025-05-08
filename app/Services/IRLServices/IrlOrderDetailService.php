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
    $reference_no = $request->reference_no ?? null;

    // Case 1: If reference_no exists in request → try to update
    if ($reference_no) {
        $order = IrlReport::where('reference_no', $reference_no)->first();

        if (!$order) {
            return "Error: Invalid IRL reference number.";
        }
    } else {
        // Case 2: No reference number → create new record with new IRL number
        $order = new IrlReport();
        $order->reference_no = IrlReport::getNextReferenceNo();
        $this->reference_no = $order->reference_no;
    }

    // If SKU_no is present (for both create or update)
    if ($request->SKU_no) {
        $order->SKU_no = $request->SKU_no;
        $this->SKU_no = $order->SKU_no;
    }

    // Optional fields
    if ($request->name || $request->phone || $request->email || $request->user_id || $request->created_by) {
        $order->name       = $request->name ?? $order->name;
        $order->phone      = $request->phone ?? $order->phone;
        $order->email      = $request->email ?? $order->email;
        $order->user_id    = $request->user_id ?? $order->user_id;
        $order->created_by = $request->created_by ?? $order->created_by;

        $this->email = $request->email;
    }

    // Ensure created_at is set only if creating
    if (!$order->exists) {
        $order->created_at = now();
        $order->status = IrlReport::DRAFT;
    }

    if ($order->save()) {
        return $order->wasRecentlyCreated 
            ? 'Order created successfully!'
            : 'Order updated successfully!';
    } else {
        return 'Error: Order could not be saved.';
    }
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