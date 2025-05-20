<?php

namespace App\Providers;

use App\Services\IRLInterfaces\IrlOrderDetailInterface;
use App\Services\IRLServices\IrlQrService;
use Illuminate\Support\ServiceProvider;
use App\Services\IRLInterfaces\IrlQrInterface;
use App\Services\IRLServices\IrlOrderDetailService;

class IrlServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IrlQrInterface::class, IrlQrService::class);
        $this->app->singleton(IrlOrderDetailInterface::class, IrlOrderDetailService::class);
        
    }

    public function boot(): void
    {
        //
    }
}
