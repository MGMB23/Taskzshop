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


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']],function(){
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::get('/tasks','\App\Http\Controllers\Admin\TasksController@first');
    Route::get('/tasks2/{id}','\App\Http\Controllers\Admin\TasksController@edit2');
    Route::put('/task-update2/{id}','\App\Http\Controllers\Admin\TasksController@updatetask2');
    Route::get('user-profile','\App\Http\Controllers\Admin\DashboardController@userprofile');
    Route::get('/{user}/impersonate',  '\App\Http\Controllers\Admin\DashboardController@impersonate')->name('users.impersonate');
    Route::get('/leave-impersonate',   '\App\Http\Controllers\Admin\DashboardController@leaveImpersonate')->name('users.leave-impersonate');
    Route::get('/myinvoice','\App\Http\Controllers\Admin\TasksController@showmyinvoice');
    Route::get('/support',function(){
        return view('admin.support');
    });
    Route::post('image-upload','\App\Http\Controllers\Admin\TasksController@storeImage')->name('image.upload');
    Route::get('generate-invoice-pdf', array('as'=> 'generate.invoice.pdf', 'uses' => '\App\Http\Controllers\Admin\TasksController@generateInvoicePDF'));

});

Route::group(['middleware' => ['auth','admin']],function(){
    Route::get('/dashboard',function(){
        return view('admin.dashboard');
    });
    Route::get('/roleregiter','\App\Http\Controllers\Admin\DashboardController@registred');
    Route::get('/role-edit/{id}','\App\Http\Controllers\Admin\DashboardController@registrededit');
    Route::put('/role-register-update/{id}','\App\Http\Controllers\Admin\DashboardController@registredupdate');
    Route::delete('/role-del/{id}','\App\Http\Controllers\Admin\DashboardController@registreddel');
    Route::get('/add-user','\App\Http\Controllers\Admin\DashboardController@useradd');

    Route::post('status','\App\Http\Controllers\Admin\TasksController@status')->name('status');
    Route::post('profile-supprimer-compte', '\App\Http\Controllers\Admin\DashboardController@supprimercompte')->name('profile-supprimer-compte');
    Route::post('task-supprimer', '\App\Http\Controllers\Admin\TasksController@supprimertask')->name('task-supprimer');


    Route::get('balanc', '\App\Http\Controllers\Admin\DashboardController@balance')->name('balanc');
    Route::get('phone', '\App\Http\Controllers\Admin\DashboardController@phone')->name('phone');
    Route::get('email', '\App\Http\Controllers\Admin\DashboardController@email')->name('email');
    Route::get('name', '\App\Http\Controllers\Admin\DashboardController@name')->name('name');



    Route::get('/tasks/{id}','\App\Http\Controllers\Admin\TasksController@edit');
    Route::get('/taskusers/{id}','\App\Http\Controllers\Admin\TasksController@taskusers');
    Route::put('/task-update/{id}','\App\Http\Controllers\Admin\TasksController@updatetask');
    Route::delete('/task-del/{id}','\App\Http\Controllers\Admin\TasksController@taskdel');
    Route::get('/save-task','\App\Http\Controllers\Admin\TasksController@save');

    Route::get('/archiveusers','\App\Http\Controllers\ArchiveuserController@archiveusers');
    Route::get('/archivetasks','\App\Http\Controllers\ArchivetaskController@archivetasks');

    Route::get('/categories','\App\Http\Controllers\CategorieController@index');
    Route::get('/save-categorie','\App\Http\Controllers\CategorieController@save');
    Route::post('categ-supprimer', '\App\Http\Controllers\CategorieController@supprimertask')->name('categ-supprimer');
    Route::get('/categories/{id}','\App\Http\Controllers\CategorieController@edit');
    Route::put('/categ-update/{id}','\App\Http\Controllers\CategorieController@updatetask');

    Route::get('/invoceliste','\App\Http\Controllers\Admin\DashboardController@invoiceshow');
    Route::get('/invoice-view/{id}','\App\Http\Controllers\Admin\TasksController@invoiceview');
    Route::post('/invoice-status-update', '\App\Http\Controllers\Admin\DashboardController@invoicestatusupdate')->name('invoice-status-update');
    Route::get('/invoicedownload/{id}','\App\Http\Controllers\Admin\TasksController@invoicedownload');


});



