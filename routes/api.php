<?php



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;



/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/

Route::post('/receive-order',[OrderController::class,'storeOrder'])->name('api.receive-order')->withoutMiddleware(['auth','throttle']);
Route::post('/delete-order',[OrderController::class,'deleteOrderDetail'])->name('api.delete-order')->withoutMiddleware(['auth','throttle']);
Route::post('/receive-bulk-order',[OrderController::class,'storeBulkOrder'])->name('api.receive-bulk-order')->withoutMiddleware(['auth','throttle']);
Route::post('/receive-order-test',[OrderController::class,'storeOrderTest'])->name('api.receive-order-test')->withoutMiddleware(['auth','throttle']);
Route::post('/publish-qr',[OrderController::class,'publishOrder'])->name('api.publish-order')->withoutMiddleware(['auth','throttle']);

Route::post('/save-pdf',[OrderController::class,'savePDF'])->name('api.save-pdf')->withoutMiddleware(['auth','throttle']);
Route::post('/save-temp-pdf',[OrderController::class,'PDFTemp'])->name('api.save-temp-pdf')->withoutMiddleware(['auth','throttle']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();

});