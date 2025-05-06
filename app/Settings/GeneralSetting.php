<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public string $site_name;

    public bool $site_active;
    public string $email;
    public string $contact_no;
    public string $address;
    public string $registration_no;
    public string $announcement;
    public string $irl_prefix;
    
    public static function group(): string
    {
        return 'general';
    }
}
