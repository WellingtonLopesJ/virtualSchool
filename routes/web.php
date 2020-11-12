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

Route::get('/','Master\MasterController@index');

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

    //Lessons and students
    Route::resource('aulas', 'Site\teacher\LessonController');
    Route::get('aulas/{slug}/cancel', 'Site\teacher\LessonController@cancel')->name('aulas.cancel');
    Route::get('aulas/{slug}/uncancel', 'Site\teacher\LessonController@unCancel')->name('aulas.uncancel');

    Route::resource('fixedLessons', 'Site\Teacher\Fixed_lessonController');

    Route::resource('alunos', 'Site\Teacher\StudentController');

    //Search API
    Route::get('searchStudents', 'Site\teacher\StudentController@search');
    Route::get('searchCurrentStudents/{slug}', 'Site\teacher\StudentController@searchCurrentStudents')->name('search.current.students');
    Route::get('searchLocations', 'Site\teacher\LocationController@search');
    Route::get('searchCurrentLocation/{slug}', 'Site\teacher\LocationController@searchCurrentLocation')->name('search.current.location');
    Route::get('fetchLessons', 'Site\teacher\LessonController@fetchLessons');

    //Balance
    Route::name('balance.')->group(function (){

        Route::get('alunos/{slug}/deposit','Site\teacher\BalanceController@deposit')->name('deposit');
        Route::post('deposit/store','Site\teacher\BalanceController@depositStore')->name('deposit.store');

    });

    Route::get('relatorios', 'Site\teacher\ReportController@index');

});
