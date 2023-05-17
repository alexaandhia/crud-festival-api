<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FanController;

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

Route::get('/', function () {
    return view('welcome');
});

//ambil semua data
Route::get('/ticket', [FanController::class, 'index'])->name('ticket');
Route::get('/token', [FanController::class, 'createToken'])->name('token'); //generate buat csrf
Route::post('/ticket/order', [FanController::class, 'store'])->name('order'); //buat tambah data
Route::get('/ticket/trash', [FanController::class, 'trash'])->name('trash'); //buat show yang udah dibuang
Route::get('/ticket/trash-restore/{id}', [FanController::class, 'restore'])->name('restore'); //buat show yang udah dibuang
Route::get('/ticket/{id}', [FanController::class, 'show'])->name('show'); //buat liat data satu doang
Route::patch('/ticket/edit/{id}', [FanController::class, 'update'])->name('update'); //buat edit satu data
Route::delete('/ticket/delete/{id}', [FanController::class, 'destroy'])->name('delete'); //untuk softdel
Route::get('/ticket/real-delete/{id}', [FanController::class, 'permanentDelete'])->name('realdel'); //buat delete asli



