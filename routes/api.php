<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\EmailVerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware'=>'auth:api'],function (){

    Route::get('singleBlog/{id}',[BlogController::class,'show']);
    Route::delete('deleteBlog/{id}',[BlogController::class,'destroy']);
    Route::get('searchBlog/{name}',[BlogController::class,'search']);
    Route::put('updateBlog',[BlogController::class,'updateBlog']);
    Route::get('logout',[BaseController::class,'logout']);
    Route::get('getBlog',[BlogController::class,'index']);





});
Route::post('postBlog',[BlogController::class,'store']);

Route::get('login',[BaseController::class,'login'])->name('login');
Route::post('register',[BaseController::class,'register']);
Route::post('login',[BaseController::class,'login']);

Route::group(['middleware'=>'apiAuth'],function (){
    Route::get('index',[BaseController::class,'index']);


});
Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);


Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail'])->middleware('auth:api');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth:api');


/*
|--------------------------------------------------------------------------
| An example of how to use the verified email feature with api endpoints
|--------------------------------------------------------------------------
|
| Here examples of a route using Sanctum middleware and verified middleware.
| And another route using Passport middleware and verified middleware.
| You can install and use one of this official packages.
|
*/

//Route::get('/verified-middleware-example', function () {
//    return response()->json([
//        'message' => 'the email account is already confirmed now you are able to see this message...',
//    ]);
//})->middleware('auth:sanctum', 'verified');

//Route::get('/verified-middleware-example', function () {
//    return response()->json([
//        'message' => 'the email account is already confirmed now you are able to see this message...',
//    ]);
//})->middleware('auth:api', 'verified');
