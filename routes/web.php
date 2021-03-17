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

Route::group(['middleware' => 'auth'], function(){
    Route::prefix('user/')->group(function(){
        Route::get('galleries/create', 'GalleryController@galleryCreate')->name('galleryCreate');
        Route::post('galleries/store', 'GalleryController@galleryStore')->name('galleryStore');
        Route::get('galleries/show/{id}', 'GalleryController@galleryShow')->name('galleryShow');
        Route::get('galleries/edit/{id}', 'GalleryController@galleryEdit')->name('galleryEdit');
        Route::post('galleries/update/{id}', 'GalleryController@galleryUpdate')->name('galleryUpdate');
        Route::get('galleries/delete/{id}', 'GalleryController@galleryDelete');

        // photo routes
        Route::get('galleries/photos/create/{id}', 'GalleryController@photoCreate')->name('photoCreate');
        Route::post('galleries/photos/store', "GalleryController@photoStore")->name('photoStore');
        Route::get('galleries/photos/show/{id}', 'GalleryController@photoShow')->name('photoShow');
        Route::get('galleries/photos/edit/{id}', 'GalleryController@photoEdit')->name('photoEdit');
        Route::post('galleries/photos/update/{id}', 'GalleryController@photoUpdate')->name('photoUpdate');
        Route::get('galleries/photos/delete/{id}', 'GalleryController@photoDelete');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
