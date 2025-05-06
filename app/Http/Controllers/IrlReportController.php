<?php

namespace App\Http\Controllers;

use App\Models\IrlReport;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IrlReportController extends Controller
{
    //

    public function index_view()
    {
        return view('pages.irl.irl-data', [
            'user' => User::class,
            'irl' => IrlReport::class,
        ]);
    }

    public function download(Request $request, $referenceNo, $emailPhone)
    {
        // $img = QrCode::size(2000)->format('png')->generate(url("report/" .  $referenceNo));

        $img = QrCode::size(2000)->format('png')->generate(IrlReport::generateURL($referenceNo, $emailPhone));

        return response($img)
        ->header('Content-type', 'application/octet-stream')
        ->header('Expires', 0)
        ->header('Content-Disposition', 'attachment; filename=' . "qr-{$referenceNo}.png")
        ->header('Content-Transfer-Encoding', 'binary')
        ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
        ->header('Content-Description', 'File Transfer');
    }
}
