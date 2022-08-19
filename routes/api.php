<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(App\Http\Controllers\testController::class)->group(function () {
    Route::get('/ping','testBd');
});


Route::controller(App\Http\Controllers\authControler::class)->group(function () {
    Route::post('/register','register');
    Route::post('/login','login');
    Route::get('/user_data','user_data')->middleware('onlyAuth');
    Route::get('/logout','logout')->middleware('onlyAuth');
});




//Admin panel api
Route::prefix('admin/')->middleware(['onlyAuth','onlyAdmin'])->group(function() {
    //genres
    Route::controller(App\Http\Controllers\genreController::class)->group(function () {
            Route::post('create_genre','create_genre');
            Route::get('get_genre','get_genre');
            Route::patch('update_genre','update_genre');
            Route::delete('delete_genre','delete_genre');
    });

    //books
    Route::controller(App\Http\Controllers\bookController::class)->group(function () {
        Route::post('create_book','create_book');
        Route::get('get_book','get_book');
        Route::patch('update_book','update_book');
        Route::delete('delete_book','delete_book');
    });

    //users
    Route::controller(App\Http\Controllers\userController::class)->group(function () {
        Route::post('create_user','create_user');
        Route::get('get_user','get_user');
        Route::patch('update_user','update_user');
        Route::delete('delete_user','delete_user');
    });

    Route::controller(App\Http\Controllers\adminController::class)->group(function () {
        Route::get('all_genres','all_genres');
        Route::get('all_users_with_book_count','all_users_with_book_count');
        Route::get('all_book_with_user_and_genres','all_book_with_user_and_genres');
    });
});




Route::prefix('user/')->group(function () {
    

    Route::get('all_books_with_user',[App\Http\Controllers\bookController::class,'all_books_with_user']);//b.
    Route::get('book_info',[App\Http\Controllers\bookController::class,'book_info']);//c.
    Route::get('user_info_with_books',[App\Http\Controllers\userController::class,'user_info_with_books']);//g.
    Route::get('all_users_with_book_count',[App\Http\Controllers\adminController::class,'all_users_with_book_count']);//f.

    Route::delete('delete_book',[App\Http\Controllers\bookController::class,'delete_book'])->middleware('onlyAuth');//e.
    Route::patch('update_book',[App\Http\Controllers\bookController::class,'update_book'])->middleware('onlyAuth');//d.
    Route::patch('update_user_info',[App\Http\Controllers\userController::class,'update_user_info'])->middleware('onlyAuth');//d.
});