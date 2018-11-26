<?php

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('guest');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'list',
    'as' => 'list.',
    ], function () {
        Route::get('/', 'EmployeesController@index')->name('index');
        Route::get('/create', 'EmployeesController@create')->name('create');
        Route::post('/create', 'EmployeesController@store')->name('store');
        Route::get('/{id}', 'EmployeesController@show')->name('show');
        Route::get('/{id}/edit', 'EmployeesController@edit')->name('edit');
        Route::put('/{id}', 'EmployeesController@update')->name('update');
        Route::get('/change-boss/{employee}', 'EmployeesController@changeBoss')->name('changeboss');
        Route::delete('/{id}', 'EmployeesController@destroy')->name('destroy');

        Route::get('/sortasc/{targetField}', 'EmployeesController@sortAsc')->name('sortAsc');
        Route::get('/sortdesc/{targetField}', 'EmployeesController@sortDesc')->name('sortDesc');
    });

Route::group([
    'middleware' => 'auth',
    'prefix' => 'ajaxlist',
    'as' => 'ajaxlist.',
    ], function () {

        Route::get('/', 'AjaxEmployeesController@index')->name('index');
        Route::post('moreitems', 'AjaxEmployeesController@moreitems')->name('moreitems');
        Route::get('/{id}', 'AjaxEmployeesEmployeesController@show')->name('show');
        Route::get('/create', 'AjaxEmployeesController@create')->name('create');
        Route::post('/create', 'AjaxEmployeesController@store')->name('store');

        Route::get('/edit/{id}', 'AjaxEmployeesController@edit')->name('edit');
        Route::put('/{id}', 'AjaxEmployeesController@update')->name('update');
        Route::get('/change-boss/{employee}', 'AjaxEmployeesController@changeBoss')->name('changeboss');
        Route::delete('/{id}', 'AjaxEmployeesController@destroy')->name('destroy');

        Route::get('/sortasc/{targetField}', 'AjaxEmployeesController@sortAsc')->name('sortAsc');
        Route::get('/sortdesc/{targetField}', 'AjaxEmployeesController@sortDesc')->name('sortDesc');

    });

Route::group([
    'prefix' => 'tree',
    'as' => 'tree.',
    ], function () {
        Route::get('/', 'TreeController@index')->name('index');
        Route::get('/children/{employee}', 'TreeController@showChildren')->name('show');
    });
Route::group([
    'prefix' => 'jstree',
    'as' => 'jstree.',
    ], function () {
        Route::get('/', 'JstreeController@index')->name('index');
        Route::post('/', 'JstreeController@sort')->name('sort')->middleware('auth');;
        Route::post('/show', 'JstreeController@show')->name('show');
        Route::post('/add-node', 'JstreeController@addNode')->name('add.node');

    });