<?php

use Illuminate\Http\Request;
use App\Program;
use App\Level;
use App\Exercise;
use App\Http\Resources\ProgramResource;

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

Route::get('/test',function(Request $request){
    $exercise = Exercise::find(1);

    return $exercise->set;
    return $exercise->program->getCurrentLevel();
    return $program->getPercentageToNextLevel();
    // return $request->user()->exercises;
    // return $program = new ProgramResource($request->user()->programProgress('Chest')->load(['exercises']));
});

Route::group(['prefix' => '/program'],function(){
    Route::get('/','ProgramController@index')->name('program.index');
    Route::get('/{program}','ProgramController@show')->name('program.show');
    Route::put('/{program}','ProgramController@update')->name('program.update');
});

Route::get('/history','HistoryController@index');
Auth::routes();


Route::get('/circle',function(){
    return view('program.voice');
});

Route::get('/home', 'HomeController@index')->name('home');
