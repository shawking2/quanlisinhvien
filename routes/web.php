<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['role:teacher']], function () { // xac minh dang nhap va quyen truy cap
    Route::prefix('quanly')->group(function () {
        Route::get('/', ['as' => 'user.home', 'uses' => 'AdminController@home',]);
        Route::prefix('roles')->group(function () {
            Route::get('/', ['as' => 'rolesManage.index', 'uses' => 'RoleController@index', 'middleware' => 'can:role-list']);
            Route::get('/create', ['as' => 'rolesManage.create', 'uses' => 'RoleController@create', 'middleware' => 'can:post-add']);
            Route::post('/create', ['as' => 'rolesManage.store', 'uses' => 'RoleController@store', 'middleware' => 'can:post-add']);
            Route::get('/edit/{id}', ['as' => 'postsManage.show', 'uses' => 'RoleController@edit', 'middleware' => 'can:post-edit']);
            Route::post('/edit/{id}', ['as' => 'postsManage.show', 'uses' => 'RoleController@edit', 'middleware' => 'can:post-edit']);
            Route::get('/delete/{id}', ['as' => 'postsManage.delete', 'uses' => 'RoleController@delete', 'middleware' => 'can:post-delete']);
        });
        //module user
        Route::prefix('users')->group(function () {
            Route::get('/', ['as' => 'usersManage.index', 'uses' => 'AdminController@index', 'middleware' => 'can:user-add']);
            Route::get('/create', ['as' => 'usersManage.create', 'uses' => 'AdminController@create', 'middleware' => 'can:role-add']);
            Route::post('/create', ['as' => 'usersManage.store', 'uses' => 'AdminController@store', 'middleware' => 'can:role-add']);
            Route::get('/edit/{id}', ['as' => 'usersManage.edit', 'uses' => 'AdminController@edit', 'middleware' => 'can:user-edit']);
            Route::post('/edit/{id}', ['as' => 'usersManage.update', 'uses' => 'AdminController@update', 'middleware' => 'can:user-edit']);
            Route::get('/delete/{id}', ['as' => 'usersManage', 'uses' => 'AdminController@delete', 'middlleware' => 'can:user-delete']);
        });
        //module posts
        Route::prefix('baiviet')->group(function () {
            Route::get('/', ['as' => 'postsManage.index', 'uses' => 'PostController@index', 'middleware' => 'can:post-list']);
            Route::get('/create', ['as' => 'postsManage.create', 'uses' => 'PostController@create', 'middleware' => 'can:post-add']);
            Route::post('/create', ['as' => 'postsManage.store', 'uses' => 'PostController@store', 'middleware' => 'can:post-add']);
            Route::get('/show/{id}', ['as' => 'postsManage.show', 'uses' => 'PostController@show', 'middleware' => 'can:post-list']);
            Route::get('/edit/{id}', ['as' => 'postsManage.edit', 'uses' => 'PostController@edit', 'middleware' => 'can:post-edit']);
            Route::post('/edit/{id}', ['as' => 'postsManage.update', 'uses' => 'PostController@update', 'middleware' => 'can:post-edit']);
            Route::get('/delete/{id}', ['as' => 'postsManage.delete', 'uses' => 'PostController@delete', 'middleware' => 'can:post-delete']);
        });
        //module challenge
        Route::prefix('thuthach')->group(function () {
            Route::get('/', ['as' => 'challengeManage.index', 'uses' => 'ChallengeController@index', 'middleware' => 'can:post-list']);
            Route::get('/create', ['as' => 'challengeManage.create', 'uses' => 'ChallengeController@create', 'middleware' => 'can:post-add']);
            Route::post('/create', ['as' => 'challengeManage.store', 'uses' => 'ChallengeController@store', 'middleware' => 'can:post-add']);
            Route::get('/edit/{id}', ['as' => 'challengeManage.edit', 'uses' => 'ChallengeController@edit', 'middleware' => 'can:post-edit']);
            Route::post('/edit/{id}', ['as' => 'challengeManage.update', 'uses' => 'ChallengeController@update', 'middleware' => 'can:post-edit']);
            Route::get('/delete/{id}', ['as' => 'challengeManage.delete', 'uses' => 'ChallengeController@delete', 'middleware' => 'can:post-delete']);
        });
    });
});
Route::get('u/{username}', 'UserController@index')->name('user');
Route::prefix('u/{username}')->group(function () {
    Route::get('thongtin', 'UserController@info')->name('thongtin_user');
    Route::post('thongtin', 'UserController@saveinfo');
    Route::post('mess', 'UserController@sendmess')->name('loinhan');
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('nopbai')->group(function () {
        Route::get('/{id}', [
            'as' => 'submit.postIndex',
            'uses' => 'SubmitController@index',
        ]);
        Route::post('/{id}', [
            'as' => 'submit.postIndex',
            'uses' => 'SubmitController@post',
        ]);
    });
    Route::prefix('answer')->group(function () {
        Route::get('/{id}', [
            'as' => 'submit.postIndex',
            'uses' => 'SubmitController@ans',
        ]);
        Route::post('/{id}', [
            'as' => 'submit.postIndex',
            'uses' => 'SubmitController@postans',
        ]);
    });
});
