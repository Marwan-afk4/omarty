<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\SuperAdmin\AdminController;
use App\Http\Controllers\Api\SuperAdmin\AppartmentController;
use App\Http\Controllers\Api\SuperAdmin\BuildingController;
use App\Http\Controllers\Api\Superadmin\CityController;
use App\Http\Controllers\Api\Superadmin\CountryController;
use App\Http\Controllers\Api\SuperAdmin\FlatController;
use App\Http\Controllers\Api\SuperAdmin\OfficeController;
use App\Http\Controllers\Api\SuperAdmin\PlanController;
use App\Http\Controllers\Api\SuperAdmin\RequestController;
use App\Http\Controllers\Api\SuperAdmin\SecurityController;
use App\Http\Controllers\Api\SuperAdmin\ShopController;
use App\Http\Controllers\Api\SuperAdmin\SubscriptionController;
use App\Http\Controllers\Api\SuperAdmin\UsersController;
use App\Http\Controllers\Api\SuperAdmin\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {
///////////////////////////////////// country ///////////////////////////////////
    Route::get('/admin/countries',[CountryController::class, 'getCountry']);

    Route::post('/admin/country/add',[CountryController::class, 'addcountry']);

    Route::put('/admin/country/update/{id}',[CountryController::class, 'updatecountry']);

    Route::delete('/admin/country/delete/{id}',[CountryController::class, 'deletecountry']);
/////////////////////////////////// City ///////////////////////////////////////////////////////
    Route::get('/admin/cities',[CityController::class, 'getCity']);

    Route::post('/admin/city/add',[CityController::class, 'addCity']);

    Route::put('/admin/city/update/{id}',[CityController::class, 'updateCity']);

    Route::delete('/admin/city/delete/{id}',[CityController::class, 'deletecity']);
////////////////////////////////// zone ////////////////////////////////////////////////////
    Route::get('/admin/zones',[ZoneController::class, 'getZone']);

    Route::post('/admin/zone/add',[ZoneController::class, 'addzonde']);

    Route::put('/admin/zone/update/{id}',[ZoneController::class, 'updatezonde']);

    Route::delete('/admin/zone/delete/{id}',[ZoneController::class, 'deletezonde']);
///////////////////////////////////// Building //////////////////////////////////////////////
    Route::get('/admin/buildings',[BuildingController::class, 'getBuilding']);

    Route::post('/admin/building/add',[BuildingController::class, 'addbuilding']);

    Route::delete('/admin/building/delete/{id}',[BuildingController::class, 'deletebuilding']);

    Route::put('/admin/building/update/{id}',[BuildingController::class, 'updatebuilding']);
/////////////////////////////////////// Flat /////////////////////////////////////////////////

    Route::post('/admin/flat/add',[FlatController::class, 'addFlat']);

    Route::get('/admin/flats',[FlatController::class, 'getflat']);

    Route::put('/admin/flat/update/{id}',[FlatController::class, 'updateflat']);

    Route::delete('/admin/flat/delete/{id}',[FlatController::class,'deleteflat']);

//////////////////////////////////// Users /////////////////////////////////////////////////////

    Route::get('/admin/users',[UsersController::class,'getusers']);

    Route::post('/admin/user/add',[UsersController::class,'adduser']);

    Route::put('/admin/user/update/{id}',[UsersController::class,'updateuser']);

    Route::delete('/admin/user/delete/{id}',[UsersController::class,'deleteuser']);

/////////////////////////////////// Security //////////////////////////////////////////////////

    Route::get('/admin/security',[SecurityController::class, 'getsecurity']);

    Route::post('/admin/security/add',[SecurityController::class, 'addsecurity']);

    Route::put('/admin/security/update/{id}',[SecurityController::class, 'updatesecurity']);

    Route::delete('/admin/security/delete/{id}',[SecurityController::class, 'deletesecurity']);

//////////////////////////////////// Admin /////////////////////////////////////////////////////

    Route::get('/admin/admins',[AdminController::class,'getadmin']);

    Route::post('/admin/admin/add',[AdminController::class,'addadmin']);

    Route::put('/admin/admin/update/{id}',[AdminController::class,'updateadmin']);

    Route::delete('/admin/admin/delete/{id}',[AdminController::class,'deleteadmin']);

//////////////////////////////////////////// Subscription /////////////////////////////////////////////////////

    Route::get('/admin/subscriptions',[SubscriptionController::class,'getsubscriptions']);

    Route::post('/admin/subscription/add',[SubscriptionController::class,'addsubscription']);

/////////////////////////////////////////// Plans /////////////////////////////////////////////////////

    Route::get('/admin/plans',[PlanController::class,'getplans']);

    Route::post('/admin/plan/add',[PlanController::class,'addplan']);

    Route::put('/admin/plan/update/{id}',[PlanController::class,'updateplan']);

    Route::delete('/admin/plan/delete/{id}',[PlanController::class,'deleteplan']);

//////////////////////////////////////// Appartments /////////////////////////////////////////////////////

    Route::get('/admin/appartments',[AppartmentController::class,'getappartments']);

    Route::post('/admin/appartment/add',[AppartmentController::class,'addAppartment']);

    Route::put('/admin/appartment/update/{id}',[AppartmentController::class,'updateAppartment']);

    Route::delete('/admin/appartment/delete/{id}',[AppartmentController::class,'deleteAppartment']);

////////////////////////////////////////////// Shops ////////////////////////////////////////////////////////////

    Route::get('/admin/shops',[ShopController::class,'getshops']);

    Route::post('/admin/shop/add',[ShopController::class,'addshop']);

    Route::put('/admin/shop/update/{id}',[ShopController::class,'updateShop']);

    Route::delete('/admin/shop/delete/{id}',[ShopController::class,'deleteShop']);

/////////////////////////////////////////////// Offices /////////////////////////////////////////////////////

    Route::get('/admin/offices',[OfficeController::class,'getoffices']);

    Route::post('/admin/office/add',[OfficeController::class,'addoffice']);

    Route::put('/admin/office/update/{id}',[OfficeController::class,'updateOffice']);

    Route::delete('/admin/office/delete/{id}',[OfficeController::class,'deleteShop']);

/////////////////////////////////////////////// Requests //////////////////////////////////////////////////////

    Route::get('/admin/requests',[RequestController::class, 'getrequests']);

    Route::post('/admin/request/add',[RequestController::class, 'addrequest']);

    Route::put('/admin/request/approved/{id}',[RequestController::class, 'statusapproved']);

    Route::put('/admin/request/rejected/{id}',[RequestController::class, 'statusrejected']);

    Route::get('/admin/request/showimage/{id}',[RequestController::class,'showimage']);



});
