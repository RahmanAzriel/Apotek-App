<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['IsGuest'])->group(function() {
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
    Route::get('/', [UserController::class, 'showLogin'])->name('login');
});

Route::middleware(['IsLogin'])->group(function() {

    Route::get('/landing', [LandingPageController::class, 'index'])->name('landing_page');
    Route::get('/logout' , [UserController::class, 'logout'])->name('logout');



Route::middleware(['IsAdmin'])->group(function() {
    Route::get('/orders' , [OrderController::class, 'indexAdmin'])->name('admin.index');
    Route::get('/orders/export-excel' , [OrderController::class, 'exportExcel'])->name('admin.exportExcel');
    Route::get('/users/export-excel' , [UserController::class, 'exportExcel'])->name('user.exportExcel');
    Route::get('/medicines/export-excel' , [MedicineController::class, 'exportExcel'])->name('medicine.exportExcel');

    Route::prefix('/Medicine')->name('medicine.')->group(function(){
        Route::get('/Add-Medicine' , [MedicineController::class, 'create'])->name('create');
        Route::post('/create-Medicine' , [MedicineController::class, 'store'])->name('create.obat');
        Route::get('/medicines/showdata' , [MedicineController::class, 'index'])->name('show');
        Route::get('/medicines/edit/{id}' , [MedicineController::class, 'edit'])->name('edit');
        Route::patch('/medicines/update/{id}' , [MedicineController::class, 'update'])->name('edit.form');
        Route::delete('/medicines/delete/{id}' , [MedicineController::class, 'destroy'])->name('destroy');
        Route::post('/edit/stock/{id}' , [MedicineController::class, 'updateStock']) ->name('update.stock');
    });
    Route::prefix('/User')->name('user.')->group(function(){
        Route::get('/users' , [UserController::class, 'index'])->name('index');   //route index mengarahkan ke method index di class UserController kegunaan dari get nya adalh untuk mengambil data dari database
        Route::get('/create' , [UserController::class, 'create'])->name('create');  //route create mengarahkan ke method create di class UserController
        Route::post('/create-user' , [UserController::class, 'store'])->name('store');
        //kegunaan post untuk menambahkan data ke database
        Route::get('/edit/{id}' , [UserController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}' , [UserController::class, 'update'])->name('update');
        //kegunaan patch untuk mengupdate data secara speksifik
        Route::delete('/destroy/{id}' , [UserController::class, 'destroy'])->name('destroy');
        //kegunaan delete untuk menghapus data dari database
    });
});

Route::middleware(['IsKasir'])->group(function() {
    Route::prefix('/purchase')->name('purchase.')->group(function(){

    Route::get('/orders' , [OrderController::class, 'index'])->name('index');
    Route::get('/form' , [OrderController::class, 'create'])->name('form');
    Route::post('/create-order' , [OrderController::class, 'store'])->name('store');
    Route::get('/show/{id}' , [OrderController::class, 'show'])->name('show');
    Route::get('/edit/{id}' , [OrderController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}' , [OrderController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}' , [OrderController::class, 'destroy'])->name('destroy');
    Route::get('/download-pdf/{id}', [OrderController::class, 'downloadPDF'])->name('download_pdf');
    });
});


});

