<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group([
    'prefix' => 'list',
    'as' => 'list.',
    ], function () {
        Route::get('/', 'EmployeesController@index')->name('index');
        Route::get('/create', 'EmployeesController@create')->name('create');
        Route::post('/create', 'EmployeesController@store')->name('store');
        Route::get('/{id}', 'EmployeesController@show')->name('show');
        Route::get('/{id}/edit', 'EmployeesController@edit')->name('edit');
        Route::put('/{id}', 'EmployeesController@update')->name('update');
        Route::delete('/{id}', 'EmployeesController@destroy')->name('destroy');

        Route::get('/sortasc/{targetField}', 'EmployeesController@sortAsc')->name('sortAsc');
        Route::get('/sortdesc/{targetField}', 'EmployeesController@sortDesc')->name('sortDesc');

    });