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
Route::get('get-user',"UsersController@getUser" );

Route::get('/2fa', 'PasswordSecurityController@show2faForm');
Route::post('/generate2faSecret', [
    'uses' => 'PasswordSecurityController@generate2faSecretCode',
    'as' => 'generate2faSecretCode'
]);

Route::post('/enable2fa', [
    'uses' => 'PasswordSecurityController@enable2fa',
    'as' => 'enable2fa'
]);

Route::post('/disable2fa', [
    'uses' => 'PasswordSecurityController@disable2fa',
    'as' => 'disable2fa'
]);
Route::post('/2faVerify', function(){
    return redirect(URL()->previous());
})->name('2faVerify')->middleware('2fa');
