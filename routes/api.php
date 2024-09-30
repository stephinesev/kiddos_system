<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DonorsController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\EventsController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/qrcode', [UsersController::class,'qrcode']);
//LOGIN
Route::get('/login_form', [UsersController::class,'login_form']);
Route::post('/login_process', [UsersController::class,'login_process']);
Route::get('/dashboard', [UsersController::class,'dashboard']);
// DONOR LOGIN
Route::get('/donor_login_form', [DonorsController::class,'donor_login_form']);
Route::post('/donor_login_process', [DonorsController::class,'donor_login_process']);
Route::get('/donor_credentials', [DonorsController::class,'donor_credentials']);
//DONOR REGISTRATION
Route::get('/create_registration',[DonationsController::class,'create_registration']);
Route::post('/registration',[DonationsController::class,'registration']);
//Beneficiary CRUD
Route::get('/create_beneficiary',[UsersController::class,'create_beneficiary']);
Route::post('/add_beneficiary',[UsersController::class,'add_beneficiary']);
Route::get('/get_beneficiary',[UsersController::class,'get_beneficiary']);
Route::get('/edit_beneficiary/{id}',[UsersController::class,'edit_beneficiary']);
Route::post('/update_beneficiary/{id}',[UsersController::class,'update_beneficiary']);
Route::get('/delete_beneficiary/{id}',[UsersController::class,'delete_beneficiary']);
Route::get('/update_beneficiary_delete/{id}',[UsersController::class,'update_beneficiary_delete']);
Route::post('/add_bmi_history',[UsersController::class,'add_bmi_history']);
Route::get('/history_beneficiary_delete/{id}',[UsersController::class,'history_beneficiary_delete']);
//Donors CRUD
Route::get('/create_donor',[DonorsController::class,'create_donor']);
Route::post('/add_donor',[DonorsController::class,'add_donor']);
Route::get('/get_donor',[DonorsController::class,'get_donor']);
Route::get('/edit_donor/{id}',[DonorsController::class,'edit_donor']);
Route::post('/update_donor/{id}',[DonorsController::class,'update_donor']);
Route::get('/delete_donor/{id}',[DonorsController::class,'delete_donor']);
//Donation CRUD
Route::get('/create_donation',[DonationsController::class,'create_donation']);
Route::post('/add_donation',[DonationsController::class,'add_donation']);
Route::get('/get_events_donation',[DonationsController::class,'get_events_donation']);
Route::get('/get_event_address/{id}',[DonationsController::class,'get_event_address']);
Route::post('/upload_image', [DonationsController::class, 'upload_image']);
Route::get('/get_donations',[DonationsController::class,'get_donations']);
Route::get('/get_images/{id}',[DonationsController::class,'get_images']);
Route::get('/get_admin_donations',[DonationsController::class,'get_admin_donations']);
Route::get('/accept_donation/{id}',[DonationsController::class,'accept_donation']);
Route::get('/decline_donation/{id}',[DonationsController::class,'decline_donation']);
Route::get('/get_notification',[DonationsController::class,'get_notification']);
Route::get('/read_notification/{id}',[DonationsController::class,'read_notification']);
Route::get('/get_notification_donor',[DonationsController::class,'get_notification_donor']);
//Calendar Data
Route::get('/create_event',[EventsController::class,'create_event']);
Route::post('/add_event',[EventsController::class,'add_event']);
Route::get('/get_events',[EventsController::class,'get_events']);
Route::get('/get_dashboard_events',[EventsController::class,'get_dashboard_events']);
Route::get('/edit_event/{id}',[EventsController::class,'edit_event']);
Route::post('/update_event/{id}',[EventsController::class,'update_event']);
Route::get('/delete_event/{id}',[EventsController::class,'delete_event']);
Route::get('/today_event',[EventsController::class,'today_event']);