<?php

use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('register' , [CompanyController::class , 'register']);
Route::post('login' , [CompanyController::class , 'login']);

Route::post('company/firebase-id' , [CompanyController::class,'firebase']);
Route::get('company/{u_id}' , [CompanyController::class,'company']);
Route::get('company-by-phone/{phone}' , [CompanyController::class,'companyByPhone']);

Route::group(['middleware' => 'auth:api'] , function (){

    Route::get('policy' , [MainController::class , 'policy']);
    Route::get('about' , [MainController::class , 'about']);

    Route::get('user' ,[CompanyController::class , 'index']);
   Route::post('logout' ,[CompanyController::class , 'logout']);

   Route::post('company/update/{id}' , [CompanyController::class , 'update' ]);
   Route::delete('company/destroy/{id}' , [CompanyController::class , 'destroy' ]);

   Route::group(['prefix' => 'category'] , function (){
       Route::get('all' , [CategoryController::class , 'index']);
       Route::post('store' , [CategoryController::class , 'store']);
       Route::delete('destroy/{id}' , [CategoryController::class , 'destroy']);
   });

   Route::group(['prefix' => 'client'] , function (){
       Route::get('all' , [ClientController::class , 'index']);
       Route::post('store' , [ClientController::class , 'store']);
       Route::delete('destroy/{id}' , [ClientController::class , 'destroy']);
   });

    Route::group(['prefix' => 'subscription'] , function (){
        Route::get('/' , [CompanyController::class , 'subscription']);
        Route::post('/make' , [CompanyController::class , 'makeSubscription']);
    });
    Route::group(['prefix' => 'products'] , function (){
        Route::get('/{id}' , [ProductController::class , 'index']);
        Route::post('/store' , [ProductController::class , 'store']);
    });

    Route::group(['prefix' => 'bills'] , function (){
       Route::get('/' , [BillController::class , 'index']);
       Route::get('single/{id}' , [BillController::class , 'singleBill']);
       Route::post('make' , [BillController::class , 'store']);
       Route::delete('destroy/{id}' , [BillController::class , 'destroy']);
       //Route::get('pdf/{id}' , [BillController::class , 'pdfBillApi']);
    });

    Route::post('make/quick-bill' , [BillController::class , 'makeQuickBill']);
    Route::get('quick-bills' , [BillController::class , 'quickBills']);

});

