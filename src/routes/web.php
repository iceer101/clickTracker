<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClickController;
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

Route::get('/', function () {
    return view('admin_panel');
});
Route::get('/click', [ClickController::class, 'processClick']);
Route::get('/success/{id}', [ClickController::class, 'success'])->name('success');
Route::get('/error/{id}', [ClickController::class, 'error'])->name('error');

Route::get('/getClicks', [AdminController::class, 'getClicks']);
Route::get('/getBadDomains', [AdminController::class, 'getBadDomains']);
Route::post('/addBadDomain', [AdminController::class, 'addBadDomain']);
