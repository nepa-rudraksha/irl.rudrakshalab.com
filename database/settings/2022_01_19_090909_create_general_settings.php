<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name', 'International Rudraksha Laboratory');
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.email', 'info@rudrakshalab.com');
        $this->migrator->add('general.contact_no', "123456");
        $this->migrator->add('general.address', "");
        $this->migrator->add('general.registration_no', "");
        $this->migrator->add('general.announcement', "");
        $this->migrator->add('general.irl_prefix', "2030213");
    }
}
