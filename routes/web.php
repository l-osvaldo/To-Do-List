<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::redirect('/', '/login');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('pending', 'ToDoListController');
    Route::post('pending/complete','ToDoListController@complete')->name('pending.complete');
    Route::get('complete', 'ToDoListController@index')->name('complete');
    Route::post('complete/deleteAll', 'ToDoListController@deleteAll')->name('complete.deleteAll');
});
