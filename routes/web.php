<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return redirect()->route('login');
// });

// Auth::routes(['register' => false]);
Route::get('/', [orderController::class, 'index'])->name('index');

Route::prefix('stock')->name('stock.')->group(function(){
    Route::get('/import-stock', [orderController::class, 'importOrder'])->name('import');
    Route::post('/upload-stock', [orderController::class, 'uploadOrder'])->name('upload');
    Route::get('export/', [orderController::class, 'export'])->name('export');
});

