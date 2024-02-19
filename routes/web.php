<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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


Route::get('/', [UserController::class, 'welcome'])->name('welcome');
Route::get('/cari-event', [UserController::class, 'cariEvent'])->name('cariEvent');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::post('/postregister', [AuthController::class, 'postregister'])->name('postregister');

Route::get('/detail/{Event}', [UserController::class, 'detail'])->name('detail');

Route::post('/postorder/{Event}', [UserController::class, 'postorder'])->name('postorder');

Route::group(['middleware' => ['auth']], function () {
    //Route Untuk Event
    Route::get('/order', [UserController::class, 'order'])->name('order');
    Route::get('/history', [UserController::class, 'history'])->name('history');
    
    Route::get('/bayar/{detailorder}', [UserController::class, 'bayar'])->name('bayar');
    Route::post('/postbayar/{detailorder}', [UserController::class, 'postbayar'])->name('postbayar');
    
    Route::get('/batalkanpesanan/{detailorder}', [UserController::class, 'batalkanpesanan'])->name('batalkanpesanan');
    
    // Route Untuk Admin
    Route::get('/admin/events', [AdminController::class, 'events'])->name('admin');
    Route::get('/admin/events/tambah', [AdminController::class, 'tambah'])->name('tambah');
    Route::get('/admin/events/hapus/{event}', [AdminController::class, 'hapus'])->name('hapus');
    Route::get('/admin/events/edit/{event}', [AdminController::class, 'edit'])->name('edit');
    Route::post('/admin/events/posttambah', [AdminController::class, 'posttambah'])->name('posttambah');
    Route::post('/admin/events/postedit/{event}', [AdminController::class, 'postedit'])->name('postedit');
    Route::post('/admin/events/{event}/update-status', [AdminController::class, 'updateEventStatus'])->name('events.update-status');
    
    Route::get('/admin/orders', [AdminController::class, 'pendingOrders'])->name('orders');
    Route::post('/admin/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    
    Route::get('/admin/log', [AdminController::class, 'log'])->name('log');

    
    Route::get('/admin/riwayat', [AdminController::class, 'completedRejectedOrders'])->name('riwayat');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/printRiwayatTransaksi', [AdminController::class, 'printRiwayatTransaksi'])->name('printRiwayatTransaksi');
    Route::get('/printInvoiceTicket/{id}', [UserController::class, 'printInvoiceTicket'])->name('printInvoiceTicket');
});







