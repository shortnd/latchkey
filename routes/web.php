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

Route::get('/', function () {return view('welcome');});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
// TODO start working on users next
Route::group(['middleware' => 'auth'], function() {
    // Needs to be above resource route
    Route::get('children/weekly-totals', 'ChildController@weekly_totals')->name('weekly_totals');
    Route::resource('children', 'ChildController');
    Route::get('children/{child}/all-checkins', 'ChildController@all_checkins')->name('all_checkins');
    Route::post('add-day/{child}', 'ChildCheckinController@addNewCheckins')->name('add_child');
    Route::patch('am-checkin/{child}', 'ChildCheckinController@am_checkin')->name('am_checkin');
    Route::patch('pm-checkin/{child}', 'ChildCheckinController@pm_checkin')->name('pm_checkin');
    Route::patch('pm-checkout/{child}', 'ChildCheckinController@pm_checkout')->name('pm_checkout');


    // Latefees
    Route::post('children/{child}/late-fee', 'LatefeeController@addLateFee')->name('latefee');
});

// Latchkey Policy & Contract pages
Route::group(['prefix' => 'policy'], function() {
    Route::get('', 'PolicyController@index');
    Route::get('edit', 'PolicyController@edit');
    Route::put('', 'PolicyController@update');
});
