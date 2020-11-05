<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('posts', 'Site\PostController')->middleware('auth');


//Panel / Master routes
Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'master.area']], function(){

    Route::get('/','Master\MasterController@index')->name('master.index');


    /*
     * User management
     * */
    Route::resource('users', 'Master\UserController');
    //Formulário de criação de user
    Route::post('users/create', 'Master\UserController@create')->name('users.create');

    //Atribui role ao user
    Route::post('users/giveRole','Master\UserController@giveRole')->name('users.give_role');
    Route::post('users/storeRole','Master\UserController@storeRole')->name('users.store_role');

    //Remove role do user
    Route::post('users/removeRole','Master\UserController@removeRole')->name('users.remove_role');

    //Ver detalhes do role
    Route::get('/role/{id}', 'Master\UserController@roleDetail')->name('role.detail');
});


//Dashboard / Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin.area']], function(){

    Route::get('/','Admin\AdminController@index')->name('admin.index');

    /*
     * Roles management
     * */
    Route::resource('roles','Admin\RoleController');
    Route::get('roles/{id}/permissions', 'Admin\RoleController@permissions')->name('roles.permissions');
    //Add permission to role form
    Route::get('roles/{id}/add_permission', 'Admin\RoleController@addPermission')->name('roles.add_permissions');
    //Store role_permission
    Route::post('/addPermission/{id}', 'Admin\RoleController@storePermission')->name('roles.store_permission');
    //Remove role_permission
    Route::delete('/removePermission', 'Admin\RoleController@removePermission')->name('roles.remove_permission');

    /*
     * Permissions management
     * */
    Route::resource('permissions', 'Admin\PermissionController');
    Route::get('permissions/{id}/roles', 'Admin\PermissionController@roles')->name('permissions.roles');

    /*
     * Tenant management
     * */
    Route::resource('tenants', 'Admin\TenantController');



});

Route::group(['middleware' => ['auth'], ], function(){

    Route::resource('aulas', 'Site\teacher\LessonController');

    Route::get('searchStudents', 'Site\teacher\StudentController@search');
    Route::get('searchLocations', 'Site\teacher\LocationController@search');
    Route::get('fetchLessons', 'Site\teacher\LessonController@fetchLessons');

});
