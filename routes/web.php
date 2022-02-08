<?php

use Illuminate\Support\Facades\Route;

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

// dd(Auth::user());
// if(auth()->user()) {
//     if(auth()->user()->hasRole("admin")) {
//         Route::prefix('/')->group(function (){
//             return redirect("/dashboard");
//         });
//     }else {
//         Route::get('/', 'User\TicketController@index');
//     }
// }else {
// }

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::get('/dashboard', 'DashboardController@index')->middleware(['auth', 'adminRole'])->name('dashboard');

Route::post('/search-tickets', 'DashboardController@searchTicket')->middleware(['auth', 'adminRole']);

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);


Route::group(['middleware' => ['auth', 'adminRole']], function () {
    Route::prefix('admin')->group(function (){
        Route::prefix('admins')->group(function (){

            Route::get('/', 'Admin\AdminController@index')->name('admin_admin');
            Route::post('/', 'Admin\AdminController@store');
            Route::get('/view/{id}', 'Admin\AdminController@details');
            Route::get('/delete/{id}', 'Admin\AdminController@destroy');
            Route::post('/delete-rows', 'Admin\AdminController@destroyRows');
            Route::post('/update', 'Admin\AdminController@update'); 
            Route::get('/features/{id}', 'Admin\AdminController@features');
            Route::post('/features/{id}', 'Admin\AdminController@postfeatures');
            Route::get('/log/{id}', 'Admin\AdminController@log');
        });

        Route::prefix('users')->group(function (){
            Route::get('/', 'Admin\UserController@index')->name('admin_user');
            Route::post('/', 'Admin\UserController@store');
            Route::get('/verify/{id}', 'Admin\UserController@verify');
            Route::get('/view/{id}', 'Admin\UserController@details');
            Route::get('/view-ticket/{id}', 'Admin\UserController@view_ticket');
            Route::get('/view-repair/{id}', 'Admin\UserController@view_repair');
            Route::get('/delete/{id}', 'Admin\UserController@destroy');
            Route::post('/delete-rows', 'Admin\UserController@destroyRows');
            Route::post('/update', 'Admin\UserController@update');

        });


        Route::prefix('ticket')->group(function (){
            Route::get("/", 'Admin\TicketController@index');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::get("/view/{id}/delete/{delete_id}", 'Admin\TicketController@reply_delete');
            Route::get("/view/{id}/edit/{edit_id}", 'Admin\TicketController@reply_edit');
            Route::any("/update-status/{id}/{status}", 'Admin\TicketController@updateStatus');
            Route::post("/update-answer", 'Admin\TicketController@updateAnswer');
            Route::get('/delete/{id}', 'Admin\TicketController@destroy');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });

        Route::prefix('ticketnew')->group(function (){
            Route::get("/", 'Admin\TicketController@indexnew');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });

        Route::prefix('ticketopen')->group(function (){
            Route::get("/", 'Admin\TicketController@indexopen');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });

        Route::prefix('ticketreply')->group(function (){
            Route::get("/", 'Admin\TicketController@indexreply');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });

        Route::prefix('ticketpending')->group(function (){
            Route::get("/", 'Admin\TicketController@indexpending');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });

        Route::prefix('ticketcomplete')->group(function (){
            Route::get("/", 'Admin\TicketController@indexcomplete');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });

        Route::prefix('ticketprocessing')->group(function (){
            Route::get("/", 'Admin\TicketController@indexprocessing');
            Route::get("/view/{id}", 'Admin\TicketController@show');
            Route::post("/send-answer", 'Admin\TicketController@sendAnswer');
        });
        
        Route::prefix('ticket-category')->group(function (){
            Route::get("/", 'Admin\TicketController@category');
            Route::post("/", 'Admin\TicketController@categoryStore');
            Route::get('/delete/{id}', 'Admin\TicketController@destroy');
            Route::post('/delete-rows', 'Admin\TicketController@destroyRows');
        });

        
        Route::get("/invoice", 'Admin\TicketController@invice')->name('invoice');
        
        Route::prefix('ticket-category')->group(function (){
        });
        Route::get("/repair/payment", 'Admin\RepairPaymentController@index');
        Route::post("/repair/paymentRequest", 'Admin\RepairPaymentController@sendPaymentRequest');
        Route::any("/repair/view/{id}", 'Admin\RepairPaymentController@detail');
        Route::any("/repair/view/{id}/download_pdf", 'Admin\RepairPaymentController@download_pdf');
        Route::any("/repair/edit/{id}", 'Admin\RepairPaymentController@edit');
        Route::get("/repair/view/{id}/delete_payment/{delete_id}", 'Admin\RepairPaymentController@payment_delete');
        Route::any("/repair/view/{id}/edit_payment/{edit_id}", 'Admin\RepairPaymentController@edit_payment');
        Route::get("/repair/view/{id}/delete/{delete_id}", 'Admin\RepairPaymentController@reply_delete');
        Route::any("/repair/view/{id}/edit/{edit_id}", 'Admin\RepairPaymentController@reply_edit');
        Route::get("/repair/view/{id}/delete_notes/{delete_id}", 'Admin\RepairPaymentController@notes_delete');
        Route::any("/repair/view/{id}/edit_notes/{edit_id}", 'Admin\RepairPaymentController@notes_edit');
        Route::get("/repair/delete/{id}", 'Admin\RepairPaymentController@destroy');
        // Route::get("/repair/paid/{id}", 'Admin\RepairPaymentController@paid');
        // Route::get("/repair/unpaid/{id}", 'Admin\RepairPaymentController@unpaid');
        Route::post("/repair_payment/update_reply", 'Admin\RepairPaymentController@updateAnswer');
        Route::post("/repair_payment/reply", 'Admin\RepairPaymentController@reply');
        Route::get("/repair/update-status/{id}/{status}", 'Admin\RepairPaymentController@updateStatus');
        Route::post("/repair_payment/notes", 'Admin\RepairPaymentController@notes');
        Route::post("/repair_payment/update_notes", 'Admin\RepairPaymentController@updateNotes');
        
        Route::get("/repair/incoming_payment", 'Admin\RepairPaymentController@index_incoming');
        Route::get("/repair/waiting_shipment_payment", 'Admin\RepairPaymentController@index_waiting_ship');
        Route::get("/repair/pending_diagnostics_payment", 'Admin\RepairPaymentController@index_diagnostics');
        Route::get("/repair/pending_client_accept_payment", 'Admin\RepairPaymentController@index_client_accept');
        Route::get("/repair/pending_client_payment", 'Admin\RepairPaymentController@index_pending_payment');
        Route::get("/repair/pending_payment", 'Admin\RepairPaymentController@index_pending');
        Route::get("/repair/shipped_return_payment", 'Admin\RepairPaymentController@index_ship_return');
        Route::get("/repair/canceled_payment", 'Admin\RepairPaymentController@index_canceled');

        Route::prefix('bitmain')->group(function (){
            Route::get("/", 'Admin\BitmainController@index');
            Route::post("/create", 'Admin\BitmainController@store');
            Route::get("/delete/{id}", 'Admin\BitmainController@destroy');
            Route::post("/delete-row", 'Admin\BitmainController@destroyRows');
        });

    });


});
Route::get("cron", 'CronController@index');
Route::post("fileUpload", 'DashboardController@fileUpload');
Route::post("uploadedFile-remove", 'DashboardController@fileRemove'); 


Route::prefix('user')->group(function (){
    Route::post("/ticket/send-answer", 'User\TicketController@sendAnswer');
    Route::post("create-ticket", 'User\TicketController@Store');
    Route::get("ticket-history", 'User\TicketController@ticketHistory');
    Route::get("ticket-view/{id}", 'User\TicketController@ticketDetail');

    Route::prefix('repair_payment')->group(function (){
        Route::get("/", 'User\RepairPaymentController@history');
        Route::post("/create", 'User\RepairPaymentController@store');
        Route::get("/view/{id}/pay/{payid}", 'User\RepairPaymentController@detail_pay');
        Route::any("/view/{id}", 'User\RepairPaymentController@detail');
        Route::post("/reply", 'User\RepairPaymentController@reply');
    });
    Route::prefix('repair_shipping')->group(function (){
        Route::get("/", 'User\RepairPaymentController@shipping_history');
    });
});
Route::get('/login/{id}', 'User\TicketController@verifyuser');
Route::any('/verification', 'User\TicketController@verification')->name('verification');
Route::any('/reset', 'User\TicketController@reset')->name('reset');
Route::any('/reset_password/{id}', 'User\TicketController@reset_password')->name('reset_password');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::any('/stripe-payment', 'StripeController@handlePost')->name('stripe.payment');
Route::post('/charge', 'StripeController@charge');
Route::get('/confirm', 'StripeController@confirm');
Route::any('/storage/attached/{filename}', 'StorageController@blockbackup');
Route::any('/label/download/{id}', 'LabelController@download');
Route::view('barcode', 'barcode');

require __DIR__.'/auth.php';
