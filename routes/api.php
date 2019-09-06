<?php

use Illuminate\Http\Request;

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


Route::apiResources(['articles' => 'API\ArticleController']);

Route::get('allArticles', 'API\ArticleController@getAllArticles');

Route::get('allUsers', 'API\ArticleController@getAllUsers');

Route::get('user', 'API\ArticleController@getUser');
