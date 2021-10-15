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
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);


Route::group(['middleware' => ['auth', 'adminRole']], function () {
    Route::prefix('admin')->group(function (){
        Route::prefix('admins')->group(function (){

            Route::get('/', 'Admin\AdminController@index');
            Route::post('/', 'Admin\AdminController@store');
            Route::get('/view/{id}', 'Admin\AdminController@details');
            Route::get('/delete/{id}', 'Admin\AdminController@destroy');
            Route::post('/delete-rows', 'Admin\AdminController@destroyRows');
            Route::post('/update', 'Admin\AdminController@update'); 
        });

        Route::prefix('users')->group(function (){

            Route::get('/', 'Admin\UserController@index');
            Route::post('/', 'Admin\UserController@store');
            Route::get('/view/{id}', 'Admin\UserController@details');
            Route::get('/delete/{id}', 'Admin\UserController@destroy');
            Route::post('/delete-rows', 'Admin\UserController@destroyRows');
            Route::post('/update', 'Admin\UserController@update');

        });


        Route::prefix('ticket')->group(function (){
            Route::get("/", 'Admin\TicketController@index');
            Route::get("/view/{id}", 'Admin\TicketController@show');
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
    });


});
Route::post("fileUpload", 'DashboardController@fileUpload');
Route::post("uploadedFile-remove", 'DashboardController@fileRemove'); 


Route::prefix('user')->group(function (){
    Route::post("/ticket/send-answer", 'User\TicketController@sendAnswer');
    Route::post("create-ticket", 'User\TicketController@Store');
    Route::get("ticket-history", 'User\TicketController@ticketHistory');
    Route::get("ticket-view/{id}", 'User\TicketController@ticketDetail');
});
Route::get('/login/{id}', 'User\TicketController@verifyuser');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});
require __DIR__.'/auth.php';
