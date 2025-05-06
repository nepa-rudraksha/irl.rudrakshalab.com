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
    protected $reference_no;
    protected $email;
    
    public function saveOrderDetail($request)
    {
        $order = new IrlReport();
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $this->email = $request->email;
        $order->reference_no = $order->getNextReferenceNo();
        $this->reference_no = $order->reference_no;
        $order->status = $order::DRAFT;  
        $order->created_by = $request->created_by;
        $order->user_id = $request->user_id;
        $order->created_at = Carbon::now()->format('Y-m-d H:i:s');
if ($order->save()) {
    return 'Order published successfully!';
} else {
    return 'Error: Order could not be saved.';
}
        //return 'Order published successfully!';
    }
    public function getReferenceNo()
    {
        return $this->reference_no;
    }
    public function getQrImg(){
        Log::info("img fails:",['reference_no'=>$this->reference_no]);
        $encryptedString = Crypt::encryptString("{$this->reference_no}|{$this->email}");
        $qrcode = QrCode::size(200)->format('png')->generate('https://irl.rudrakshalab.com/validate-report/' . $encryptedString);

        return base64_encode((string) $qrcode);
        
    }
}

?>