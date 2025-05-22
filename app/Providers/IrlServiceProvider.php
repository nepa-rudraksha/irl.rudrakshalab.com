<?php



namespace App\Providers;

use App\Interfaces\IRLInterfaces\IrlReportRepositoryInterface;
use App\Interfaces\IRLInterfaces\IrlOrderDetailInterface;
use App\Interfaces\IRLInterfaces\IrlPdfDBSaveServiceInterface;
use App\Interfaces\IRLInterfaces\IrlPdfInterface;
use App\Interfaces\IRLInterfaces\IrlPdfStoreServiceInterface;
use App\Services\IRLServices\IrlQrService;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\IRLInterfaces\IrlQrInterface;

use App\Services\IRLServices\IrlOrderDetailService;
use App\Services\IRLServices\IrlPdfService;
use App\Repositories\IrlReportRepository;
use App\Services\IRLServices\IrlPdfDBSaveService;
use App\Services\IRLServices\IrlPdfStoreService;

class IrlServiceProvider extends ServiceProvider

{

    public function register(): void

    {

        $this->app->singleton(IrlQrInterface::class, IrlQrService::class);

        $this->app->singleton(IrlOrderDetailInterface::class, IrlOrderDetailService::class);

        $this->app->singleton(IrlPdfInterface::class, IrlPdfService::class);

        $this->app->singleton(IrlReportRepositoryInterface::class, IrlReportRepository::class);

        $this->app->singleton(IrlPdfStoreServiceInterface::class, IrlPdfStoreService::class);
        $this->app->singleton(IrlPdfDBSaveServiceInterface::class, IrlPdfDBSaveService::class);

        

    }



    public function boot(): void

    {

        //

    }

}

