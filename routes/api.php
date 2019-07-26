<?php

//use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::group([

    'middleware' => 'api'
//    'prefix' => 'auth'

], function ($router) {
    //Auth API
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
    Route::post('resetPassword', 'ChangePasswordController@process');
    //Cars API
    Route::post('cars', 'CarController@store');
    Route::get('cars', 'CarController@index');
    Route::get('cars/{id}', 'CarController@show');
    Route::get('cars/{id}/edit', 'CarController@edit');
    Route::put('cars/{id}', 'CarController@update');
    Route::delete('cars/{id}', 'CarController@destroy');
    //Vendor API
    Route::post('vendors', 'VendorController@store');
    Route::get('vendors', 'VendorController@index');
    Route::get('vendors/{id}', 'VendorController@show');
    Route::get('vendors/{id}/edit', 'VendorController@edit');
    Route::put('vendors/{id}', 'VendorController@update');
    Route::delete('vendors/{id}', 'VendorController@destroy');
    //Staff API
    Route::post('employees', 'EmployeeController@store');
    Route::get('employees', 'EmployeeController@index');
    Route::get('employees/{id}', 'EmployeeController@show');
    Route::get('employees/{id}/edit', 'EmployeeController@edit');
    Route::put('employees/{id}', 'EmployeeController@update');
    Route::delete('employees/{id}', 'EmployeeController@destroy');
    //Customer API
    Route::post('customers', 'CustomerController@store');
    Route::get('customers', 'CustomerController@index');
    Route::get('customers/{id}', 'CustomerController@show');
    Route::get('customers/{id}/edit', 'CustomerController@edit');
    Route::put('customers/{id}', 'CustomerController@update');
    Route::delete('customers/{id}', 'CustomerController@destroy');
    //Search API
    Route::post('search', 'BookingController@search');
    //Booking API
    Route::post('book', 'BookingController@book');
//    Route::get('customers', 'CustomerController@index');
//    Route::get('customers/{id}', 'CustomerController@show');
//    Route::get('customers/{id}/edit', 'CustomerController@edit');
//    Route::put('customers/{id}', 'CustomerController@update');
//    Route::delete('customers/{id}', 'CustomerController@destroy');
});
