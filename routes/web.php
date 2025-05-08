<?php

use App\Http\Controllers\IrlReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\IRLValidationController;
use Spatie\Honeypot\ProtectAgainstSpam;


use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Php;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::view('/', 'web.index');
Route::get('/',[IRLValidationController::class, 'web'])->name('web.index');
Route::view('/contact-us', 'web.contact');
Route::get('/contact-us',[IRLValidationController::class, 'contact'])->name('web.contact');
Route::view('/validate-report/', 'web.validateform');
Route::get('/information',[IRLValidationController::class, 'information'])->name('web.information');

Route::group(['middleware' => ProtectAgainstSpam::class ], function () {
    Route::POST('/generate-report', [FrontController::class, 'getIrlReport'])->name('irl-report');
    Route::get('/validate-report/{referenceNo}/user/{emailPhone}', [FrontController::class, 'validateIrlReport'])->name('irl-report.validate');
    Route::get('/validate-report/{encryptedUrl}', [FrontController::class, 'validateIrlReportEncrypted'])->name('irl-report.validate.encrypted');
    Route::get('/validate-inventory-report/{encryptedUrl}', [FrontController::class, 'validateIrlReportInventoryEncrypted'])->name('irl-report.validate.inventory.encrypted');
    Route::POST('/contact-us', [FrontController::class, 'postContactForm'])->name('irl-report');
});

Route::group([ "middleware" => ['auth:sanctum', 'verified'] ], function () {
    Route::get('/dashboard', [ IrlReportController::class, "index_view" ])->name('dashboard');
    Route::get('/user', [ UserController::class, "index_view" ])->name('user');
    Route::view('/user/new', "pages.user.user-new")->name('user.new');
    Route::view('/user/edit/{userId}', "pages.user.user-edit")->name('user.edit');

    Route::get('/irl-reports', [ IrlReportController::class, "index_view" ])->name('irl');
    Route::get('/irl-reports/reference-no/{referenceNo}/downloadrqcode/{emailPhone}', [ IrlReportController::class, "download" ])->name('irl.downloadqr');
    Route::view('/irl-reports/new', "pages.irl.irl-new")->name('irl.new');
    Route::view('/irl-reports/edit/{irlReportId}', "pages.irl.irl-edit")->name('irl.edit');

    Route::get('phpinfo', function () {
        phpinfo();
    });
});
