<?php


Route::get('/',"DtrController@index");

Auth::routes();

Route::post("printer","DtrController@printer")->name('dtr.print');
Route::post("getDtr","DtrController@getDtr");
Route::post("getEmployee","DtrController@getEmployee");
Auth::routes();

Route::get("pdf","DtrController@open_pdf");

Route::get("change-password","UsersController@changePassword")->name('change-password');
Route::post('update-password',"UsersController@updatePassword" );
