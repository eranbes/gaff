<?php

use App\Http\Controllers\CompanyController;
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

Route::get('publishers', 'PublisherController@index');
Route::get('publishers/{id}', 'PublisherController@show');
Route::post('publishers', 'PublisherController@store');
Route::put('publishers/{id}', 'PublisherController@update');

Route::get('crawls', 'CrawlController@index');
Route::patch('crawls/{id}', 'CrawlController@run');

Route::get('send', 'DailyController@run');
