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

Route::resource('sample', 'SampleController');
Route::resource('projet', 'ProjetController');
Route::resource('message', 'MessageController');

Route::get('projet/{projet}/retrieveChatMessages',array('uses' => 'ProjetController@retrieveChatMessages'))->name("projet.retrieveChatMessages");
Route::post('projet/{projet}/sendMessage',array('uses' => 'ProjetController@sendMessage'))->name("projet.sendMessage");
Route::get('projet/{projet}/invite', array('uses' => 'ProjetController@invite'))->name("projet.invite");

Route::get('projet/{projet}/chat',array('uses' => 'ProjetController@getChat'))->name("projet.getChat");

Route::get('projet/{projet}/{version}', array('uses' => 'ProjetController@getUpdate'))->name('projet.getUpdates');
