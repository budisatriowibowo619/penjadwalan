<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', [HomeController::class, 'page_calendar']);
Route::get('/pageCalendar', [HomeController::class, 'page_calendar']);

Route::get('/pageRoom/{slug}', [HomeController::class, 'page_room']);
Route::post('/processJadwal', [HomeController::class, 'ajax_pcs_jadwal']); // Proses Master Kendaraan
Route::get('/deleteJadwal', [HomeController::class, 'ajax_del_jadwal']);