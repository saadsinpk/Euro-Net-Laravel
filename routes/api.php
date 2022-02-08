<?php

use App\Http\Controllers\API\RepairPaymentController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dashboard', 'API\DashboardController@index');
Route::get("admin/ticket/repair/reply", 'API\TicketController@indexreply');

Route::get("user/ticket/repair/reply", 'API\TicketController@userindexreply');


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::get('users', [UserController::class, 'index']);
Route::get('admins', [UserController::class, 'admins']);
Route::put('user/{id}', [UserController::class, 'update']);

Route::get('admin/delete/{id}', 'API\Admin\AdminController@destroy');
Route::post('admin/delete-rows', 'API\Admin\AdminController@destroyRows');
//ticket

Route::get("admin/tickets", [TicketController::class, 'index']);
Route::get("admin/ticket/show/{id}", [TicketController::class, 'show']);
Route::get("admin/ticket/show/{id}", [TicketController::class, 'show']);
Route::get("admin/ticket/delete/{id}", [TicketController::class, 'destroy']);
Route::get("admin/ticket/update/{id}/{status}", [TicketController::class, 'updateStatus']);


//repair payment
Route::get("admin/repair/payments", [RepairPaymentController::class, 'index']);
Route::post("admin/repair/payment/create", [RepairPaymentController::class, 'create']);
Route::get("admin/repair/view/{id}/delete_payment/{delete_id}", [RepairPaymentController::class, 'payment_delete']);
Route::get("admin/repair/view/{id}/edit_payment/{edit_id}", [RepairPaymentController::class, 'edit_payment']);


Route::get("admin/repair/view/{id}", [RepairPaymentController::class, 'detail']);
Route::get("admin/repair/edit/{id}", [RepairPaymentController::class, 'edit']);

Route::get("admin/repair/update-status/{id}/{status}", [RepairPaymentController::class, 'updateStatus']);
Route::get("admin/repair/delete/{id}", [RepairPaymentController::class, 'destroy']);

//Route::get("admin/notes", [RepairPaymentController::class, 'notes']);
Route::get("admin/repair_payment/notes", [RepairPaymentController::class, 'repair_notes']);
Route::post("admin/repair_payment/notes", [RepairPaymentController::class, 'notes']);
Route::get("admin/repair/view/{id}/edit_notes/{edit_id}", [RepairPaymentController::class, 'notes_edit']);
Route::get("admin/repair/view/{id}/delete_notes/{delete_id}", [RepairPaymentController::class, 'notes_delete']);

Route::get('admin/log/{id}', 'API\Admin\AdminController@log');
Route::get('admin/features/{id}', 'API\Admin\AdminController@features');
Route::post('admin/features/{id}', 'API\Admin\AdminController@postfeatures');

Route::get('admin/verify/{id}', 'API\UserController@verify');
////user

Route::any("user/repair/view/{id}", 'API\User\RepairPaymentController@detail');

Route::post("user/create-ticket", [TicketController::class, 'store']);
Route::get("user/ticket-history", [TicketController::class, 'ticketHistory']);

Route::post("user/repair_payment/create", 'API\User\RepairPaymentController@store');
Route::get("user/repair_payment", 'API\User\RepairPaymentController@history');

Route::get("ticket-category", 'API\User\TicketController@category');
Route::get("/bitmain-list", 'API\UserController@bitmain');
Route::get("ticket-view/{id}", 'API\User\TicketController@ticketDetail');

Route::any('payment/pay', 'API\User\RepairPaymentController@pay');


Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class);
});