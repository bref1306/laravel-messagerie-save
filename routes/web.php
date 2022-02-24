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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/conversations', [App\Http\Controllers\ConversationsController::class,'index'])->name('conversations');
Route::get('/conversations/{user}', [App\Http\Controllers\ConversationsController::class,'show'])
->middleware('can:talkTo,user')
->name('conversations.show');
Route::post('/conversations/{user}', [App\Http\Controllers\ConversationsController::class,'store'])->middleware('can:talkTo,user');