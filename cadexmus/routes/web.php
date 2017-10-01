<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect()->route('projet.index');
});

Auth::routes();

/* Projet */

Route::resource('projects', 'ProjetController', ['names' => [
    'index' => 'projet.index',
    'show' => 'projet.show',
    'create' => 'projet.create',
    'store' => 'projet.store',
    'update' => 'projet.update',
    'destroy' => 'projet.destroy',
    'edit' => 'projet.edit',
]]);

Route::get('projects/{project}/retrieveChatMessages', 'ProjetController@retrieveChatMessages')->name("projet.retrieveChatMessages");
Route::get('projects/{project}/retrieveRecentChatMessages', 'ProjetController@retrieveRecentChatMessages')->name("projet.retrieveRecentChatMessages");
Route::post('projects/{project}/sendMessage', 'ProjetController@sendMessage')->name("projet.sendMessage");
Route::post('projects/{project}/invite', 'ProjetController@invite')->name("projet.invite");

Route::get('projects/{project}/chat', 'ProjetController@getChat')->name("projet.getChat");

Route::get('projects/{project}/{version}', 'ProjetController@getUpdate')->name('projet.getUpdates');

/* Sample */


Route::get('sample/filter', 'SampleController@filter')->name('sample.filter');
Route::resource('sample', 'SampleController');
