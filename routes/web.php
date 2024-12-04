<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\BlogController;
use App\Models\Admin;
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
    // return view('welcome');
});
Route::get('/',[AdminController::class,'login'])->name('login');
Route::get('/create',[AdminController::class,'create'])->name('create');
Route::post('/do_login',[AdminController::class,'do_login'])->name('do_login');

Route::POST('/do_register',[CreateController::class,'do_register'])->name('do_register');
Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
Route::get('/logout',[CreateController::class,'logout'])->name('logout');