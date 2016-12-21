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
    if(Auth::guest()){
        return redirect()->route('login');
    }else{
        $projets = Auth::user()->projets;
        if(count($projets)==0)
            return redirect()->route('projet.index');
        // todo : redirect sur le projet le plus récemment modifié plutôt que le premier projet
        return redirect()->route('projet.show',['projet'=>$projets[0]]);
    }
});

Auth::routes();

/* Projet */

Route::resource('projet', 'ProjetController');

Route::get('projet/{projet}/retrieveChatMessages', 'ProjetController@retrieveChatMessages')->name("projet.retrieveChatMessages");
Route::post('projet/{projet}/sendMessage', 'ProjetController@sendMessage')->name("projet.sendMessage");
Route::post('projet/{projet}/invite', 'ProjetController@invite')->name("projet.invite");

Route::get('projet/{projet}/chat', 'ProjetController@getChat')->name("projet.getChat");

Route::get('projet/{projet}/{version}', 'ProjetController@getUpdate')->name('projet.getUpdates');

/* Sample */


Route::get('sample/filter', 'SampleController@filter')->name('sample.filter');
Route::resource('sample', 'SampleController');
