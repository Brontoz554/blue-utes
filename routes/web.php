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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/profile', 'HomeController@index')->name('profile');
Route::get('/setwebhook-telegramm-bot', 'TelegramBotController@setWebhook');
Route::any('/telegramm-bot-message', 'TelegramBotController@getMessage');
Route::get('/summernote-example', 'ExampleController@summernote')->name('summernote');

Route::get('/create-news', 'NewsController@createView')->name('create.news.view');
Route::post('/create-news', 'NewsController@store')->name('create.news');
Route::get('/news', 'NewsController@index')->name('news');
Route::get('/all-news', 'NewsController@show')->name('show.news');
Route::get('/remove-news/{id}', 'NewsController@destroy')->name('destroy.news');
Route::get('/edit-news/{id}', 'NewsController@editView')->name('edit.news.view');
Route::post('/edit-news/', 'NewsController@edit')->name('edit.news');

Route::get('/all-pages', 'PagesController@show')->name('pages');
Route::get('/remove-pages/{id}', 'PagesController@destroy')->name('destroy.page');
Route::get('/edit-page/{id}', 'PagesController@editView')->name('edit.page.view');
Route::post('/edit-page/', 'PagesController@edit')->name('edit.page');
Route::get('/create-page', 'PagesController@createView')->name('create.page.view');
Route::post('/create-page', 'PagesController@store')->name('create.page');

Route::post('/request', 'RequestController@callMe')->name('request');

Route::get('/room-type', 'RoomsController@createTypeView')->name('room.type.view');
Route::post('/create-room-type', 'RoomsController@storeType')->name('create.room.type');
Route::get('/destroy-room-type/{id}', 'RoomsController@destroyType')->name('destroy.room.type');
Route::post('/edit-type', 'RoomsController@editType')->name('edit.type');

Route::get('/create-room', 'RoomsController@createRoomView')->name('create.room.view');
Route::get('/rooms', 'RoomsController@RoomView')->name('room.view');
Route::post('/create-room', 'RoomsController@storeRoom')->name('create.room');
Route::get('/destroy-room/{id}', 'RoomsController@destroyRoom')->name('destroy.room');
Route::post('/edit-room', 'RoomsController@editRoom')->name('edit.room');

Route::get('/create-tariff', 'TariffController@createView')->name('create.tariff.view');
Route::post('/create-tariff', 'TariffController@store')->name('create.tariff');
Route::get('/tariff', 'TariffController@index')->name('tariff');
Route::post('/edit-tariff', 'TariffController@editTariff')->name('edit.tariff');
Route::get('/destroy-tariff/{id}', 'TariffController@destroyTariff')->name('destroy.tariff');
