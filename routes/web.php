<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
 Route::get('/','Front\MainController@index' )->name('home');

//Route::get('pdf/{id}' , [\App\Http\Controllers\Api\BillController::class , 'pdfBill']);




Route::get('/qrcode/{id}/{type}/{coId}', [\App\Http\Controllers\Api\BillController::class, 'QrIndex']);
Route::get('/bill/{id}/{type}/{coId}' , [\App\Http\Controllers\Api\BillController::class , 'singleBillWeb']);
