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

    return view('welcome');
});

Route::get('/projet/{projet}/chat', function($projet)
{
	return view('chat.index')->with('projet',$projet);
});


Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth');
Route::resource('sample', 'SampleController');
Route::resource('projet', 'ProjetController');
Route::resource('message', 'MessageController');


Route::get('projet',array('uses' => 'ProjetController@index'));
Route::get('projet/{projet}/retrieveChatMessages',array('uses' => 'ProjetController@retrieveChatMessages'))->name("projet.retrieveChatMessages");
Route::get('projet/{projet}/isTyping',array('uses' => 'ProjetController@isTyping'))->name("projet.isTyping");
Route::get('projet/{projet}/notTyping',array('uses' => 'ProjetController@notTyping'))->name("projet.notTyping");
Route::get('projet/{projet}/retrieveTypingStatus',array('uses' => 'ProjetController@retrieveTypingStatus'))->name("projet.retrieveTypingStatus");
Route::post('projet/{projet}/sendMessage',array('uses' => 'ProjetController@sendMessage'))->name("projet.sendMessage");

Route::get('getUserName',array('uses' => 'ProjetController@getUserName'))->name("projet.getUserName");


/*Route::post('message/{projet}/chat','MessageController@createInProjet')->name("message.createInProjet");
Route::get('message/{projet}/chat','MessageController@getByProjet')->name("message.getByProjet");*/


Route::get('projet/{projet}/{version}', array('uses' => 'ProjetController@getUpdate'))->name('projet.getUpdates');

