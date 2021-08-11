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

Route::get('/', 'HomeController@index');

Route::get('/report/{organization}', [
    'uses' => 'ReportController@report',
    'as' => 'report',
]);

Route::post('/showreport', [
    'uses' => 'ReportController@showReport',
    'as' => 'showreport',
]);

Route::get('/notifications', [
    'uses' => 'AuditController@notifications',
    'as' => 'notifications',
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resources([
    'organizations'=>'OrganizationController',
    'branches'=>'BranchController',
    'positions'=>'PositionController',
    'pchanges'=>'PosChangeController',
    'uchanges'=>'UserChangeController',
    'audits'=>'AuditController',
    'employees'=>'EmployeeController',
    'observers'=>'ObserverController',
]);

