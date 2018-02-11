<?php
//use Auth;
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

//Route::get('/', function () {
//    return view('welcome');
//});

if(Auth::check()){
Route::get('/', function () {
    return view('welcome');
});   }else{
Route::get('/', 'HomeController@index');
}
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/getFoodList', 'HomeController@getFoodList')->name('getFoodList');
Route::post('/giveVote', 'HomeController@giveVote')->name('giveVote');
