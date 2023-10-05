<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SearchTableController;
use App\Http\Controllers\HomeController;

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
Route::post('/stripe/webhook', 'WebhookController@handle');

Route::post('add/form', [FormController::class, 'store'])->name('api.forms.stores');
Route::post('login',[LoginController::class,'login'])->name('api.login');
Route::get('table',[SearchTableController::class,'apitable'])->name('api.table');
Route::get('project-features/',[HomeController::class, 'projectFeature'])->name('superadmin.projectfeature');
// Route::get('test', function(){
//     return response()->json("hehehehhe");
// });
