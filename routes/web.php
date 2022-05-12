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

use App\BookingRooms;
use App\Tariff;
use Carbon\Carbon;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/setwebhook-telegramm-bot', 'TelegramBotController@setWebhook');
Route::any('/telegramm-bot-message', 'TelegramBotController@getMessage');

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

Route::get('/room-type', 'TypeRoomsController@createTypeView')->name('room.type.view');
Route::post('/create-room-type', 'TypeRoomsController@storeType')->name('create.room.type');
Route::get('/destroy-room-type/{id}', 'TypeRoomsController@destroyType')->name('destroy.room.type');
Route::post('/edit-type', 'TypeRoomsController@editType')->name('edit.type');

Route::get('/create-room', 'RoomsController@createRoomView')->name('create.room.view');
Route::get('/rooms', 'RoomsController@RoomView')->name('room.view');
Route::post('/create-room', 'RoomsController@storeRoom')->name('create.room');
Route::get('/destroy-room/{id}', 'RoomsController@destroyRoom')->name('destroy.room');
//Route::post('/edit-room', 'RoomsController@editRoom')->name('edit.room');
Route::get('/edit-room/{id}', 'RoomsController@editRoomView')->name('edit.room.view');
Route::post('/edit-room/', 'RoomsController@editRoom')->name('edit.room');
Route::get('/repair-rooms/{room}', 'RoomsController@repairRoom')->name('repair.room');


Route::get('/create-tariff', 'TariffController@createView')->name('create.tariff.view');
Route::post('/create-tariff', 'TariffController@store')->name('create.tariff');
Route::get('/tariffs', 'TariffController@index')->name('tariff');
Route::get('/edit-tariff/{tariff}', 'TariffController@editTariffView')->name('edit.tariff.view');
Route::post('/edit-tariff}', 'TariffController@editTariff')->name('edit.tariff');
Route::get('/destroy-tariff/{id}', 'TariffController@destroyTariff')->name('destroy.tariff');

Route::get('/treatment', 'TreatmentController@treatmentView')->name('treatment.view');
Route::post('/create-treatment', 'TreatmentController@storeTreatment')->name('create.treatment');
Route::get('/destroy-treatment/{id}', 'TreatmentController@destroyTreatment')->name('destroy.treatment');
Route::post('/edit-treatment', 'TreatmentController@editTreatment')->name('edit.treatment');

Route::get('/eating', 'EatingController@eatingView')->name('eating.view');
Route::post('/create-eating', 'EatingController@storeEating')->name('create.eating');
Route::get('/destroy-eating/{id}', 'EatingController@destroyEating')->name('destroy.eating');
Route::post('/edit-eating', 'EatingController@editEating')->name('edit.eating');

Route::get('/services', 'ServicesController@servicesView')->name('services.view');
Route::post('/create-services', 'ServicesController@storeServices')->name('create.services');
Route::get('/destroy-services/{id}', 'ServicesController@destroyService')->name('destroy.services');
Route::post('/edit-services', 'ServicesController@editServices')->name('edit.services');

Route::post('/booking', 'BookingController@booking')->name('create.booking');
Route::post('/checkRoomBooking', 'BookingController@checkRoomBooking')->name('checkRoomBooking');

Route::get('/booking-board', 'BookingController@index')->name('booking.board');
Route::get('/booking', 'BookingController@storeView')->name('booking');
Route::get('/check-room-booking', 'BookingController@checkRoom')->name('check.room.booking');
Route::get('/destroy-booking/{booking}', 'BookingController@destroyBooking')->name('destroy.booking');
Route::get('/edit-booking/{booking}', 'BookingController@editBookingView')->name('edit.booking.view');
Route::post('/edit-booking/', 'BookingController@editBooking')->name('edit.booking');
Route::get('/edit-nutrition-booking/{booking}', 'BookingController@editNutritionView')->name('edit.nutrition.view');
Route::post('/edit-nutrition', 'BookingController@editNutrition')->name('edit.nutrition');

Route::post('/getTariffInfo', 'TariffController@getTariffInfo')->name('getTariffInfo');
Route::post('/getTariffRoomInfo', 'TariffController@getTariffRoomInfo')->name('getTariffRoomInfo');
Route::post('/getRoomPrice', 'RoomsController@getRoomPrice')->name('getRoomPrice');

Route::get('/clients', 'ClientController@clients')->name('clients');
Route::post('/edit-client', 'ClientController@editClient')->name('edit.client');

Route::get('/room-service', 'RoomServiceController@roomServiceView')->name('room.service.view');
Route::post('/room-service', 'RoomServiceController@storeRoomService')->name('create.room.service');
Route::get('/destroy-room-service/{id}', 'RoomServiceController@destroyRoomService')->name('destroy.room.service');
Route::post('/edit-room-service', 'RoomServiceController@editRoomService')->name('edit.room.service');

Route::get('/reception', 'ReceptionController@index')->name('reception');

Route::get('/kitchen', 'KitchenController@index')->name('kitchen');

Route::post('/changeDepartureTime', 'BookingController@changeDepartureTime')->name('changeDepartureTime');
Route::post('/changeCheckInTime', 'BookingController@changeCheckInTime')->name('changeCheckInTime');

Route::get('/test-booking', 'BookingController@indexView')->name('indexView');
Route::post('/getBookings', 'BookingController@getBookings')->name('getBookings');
Route::get('/getAllRoomBookings/{room}', 'RoomsController@getAllRoomBookings')->name('getAllRoomBookings');

Route::get('/bla', function () {
    $tariff = Tariff::where('id', '=', 20)->first();
    $tariff['treatment'] = $tariff->treatments;
    $tariff['services'] = $tariff->services;
    $tariff['eatings'] = $tariff->eatings;
    dd($tariff);
//    dd(ceil(($hoursBefore / ($hoursAfter / 100)) * $booking->price));
});
