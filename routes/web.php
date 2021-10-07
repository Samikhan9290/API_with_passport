<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
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


Route::group(['middleware'=>'apiAuth'],function (){
    Route::get('/', function () {
        return view('welcome');
    });

});
Route::get('index',[WebsiteController::class,'index']);
