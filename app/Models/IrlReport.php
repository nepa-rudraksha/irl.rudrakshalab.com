<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;

class IrlReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PUBLISHED = 1;
    const DRAFT     = 0;

    protected $appends = ['report_pdf_url'];

    public static $prefix = "2030213";
    protected $casts = [
        // 'created_at' => 'datetime:Y-m-d',
        'created_at' => "date:Y-m-d\TH:i",
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'qr_code',
        'pdf_url',
        'reference_no',
        'created_by',
    ];


    /**
     * Search query in multiple whereOr
     */
    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->orWhere('reference_no', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%');
    }

    public static function getNextReferenceNo()
    {
        $record = self::latest()->first();

        $prefix = self::$prefix;


        if (empty($record->reference_no)) {
            return $prefix . '0001';
        }

        $expNum = preg_split('/^2030213/', $record->reference_no);

        //increase 1 with last invoice number
        $nextReferenceNo = $prefix . str_pad($expNum[1] + 1, 4, "0", STR_PAD_LEFT);
        return $nextReferenceNo;
    }


    public function isPdfUploaded()
    {
        if ($this->pdf_url == null || Storage::exists(public_path('report/' . $this->pdf_url))) {
            return false;
        } else {
            return true;
        }
    }


    public function getReportPdfUrlAttribute()
    {
        return Storage::url('report/' . $this->pdf_url);
    }

    public static function getPdfUrl($filename)
    {
        return Storage::url('report/' . $filename);
    }
    public static function getNextReferenceNoV2()
    {
        $record = self::latest()->first();
        $prefix = "IRL" . date('Y');


        if (isset($record->reference_no) || empty($record->reference_no)) {
            return $prefix . '-' . '-0001';
        }
        $expNum = explode('-', $record->reference_no);

        $firstDayOfYear = (new DateTime('1st January'))->format('Y-m-d');

        //check first day in a year
        $today = date("Y-m-d");

        if ($firstDayOfYear ==  $today && $expNum[0] != $prefix) {
            $nextReferenceNo =  $prefix . '-' . '0001';
        } else {
            //increase 1 with last invoice number
            $nextReferenceNo = $prefix . '-' . str_pad($expNum[1] + 1, 4, "0", STR_PAD_LEFT);
        }
        return $nextReferenceNo;
    }

    public static function generateURL($referenceNo, $identifier)
    {

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $encryptedUrl =  Crypt::encryptString($referenceNo . '|' .  $identifier);
        }
        else{
    // Use custom encryption key from .env (must be base64-encoded 32-byte key)
    $base64Key = env('CUSTOM_KEY'); // Example: base64:M0dydVp4aVNTSmR2WlFuY0xLaElDV2FHTVdjQUdCc3k=
    $key = base64_decode(str_replace('base64:', '', $base64Key));
    // Create Encrypter instance with custom key and AES-256-CBC cipher
    $encrypter = new Encrypter($key, 'AES-256-CBC');
    // Encrypt the string: referenceNo|identifier
    $encryptedUrl = $encrypter->encrypt("{$referenceNo}|{$identifier}");
        }
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        return route('irl-report.validate.encrypted', ['encryptedUrl' => $encryptedUrl]);
    }
    // Return encrypted route
    return route('irl-report.validate.inventory.encrypted', ['encryptedUrl' => $encryptedUrl]);
    }

    public function generateEncryptedUrl()
    {
        // return Crypt::encryptString($referenceNo . '|' + $emailPhone);
    }
}
