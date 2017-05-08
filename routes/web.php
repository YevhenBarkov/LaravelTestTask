<?php

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

use App\Http\Controllers\Test\TestController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', 'Test\TestController@words');
Route::get('/hash', 'Test\TestController@hash');
Route::get('/getAllSavedHashes', 'Test\TestController@getAllUserHashes');
Route::get('/getLastSavedHashes', 'Test\TestController@getLastUserHashes');

Route::get('/getSavedHashes/{ip}', 'Test\TestController@getSavedHashes');

Route::post('/save', 'Test\TestController@save');


