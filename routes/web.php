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

Auth::routes();


// separating routes which guest should see from the ones should not see
if (Request::path() == '/') {
  Route::get('{path}', function () { return view('layouts.app'); })->where('path', '[\/\w\.-]*');
}else {
  Route::get('{path}', function () { return view('layouts.app'); })->where('path', '[\/\w\.-]*')->middleware('auth');
}
