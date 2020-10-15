<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('domains', 'DomainController@index');
Route::post('domains', 'DomainController@store');
Route::put('domains', 'DomainController@update');

Route::get('publishers', 'PublisherController@index');
Route::get('publishers/{id}', 'PublisherController@show');
Route::post('publishers', 'PublisherController@store');
Route::put('publishers/{id}', 'PublisherController@update');

