<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});




$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    //文件处理
    $api->post('attachment/upload', [
        'as' => 'attcachment.upload',
        'uses' => 'AttachmentController@upload',
    ]);
    $api->post('attachment/delete', [
        'as' => 'attcachment.delete',
        'uses' => 'AttachmentController@delete',
    ]);

    $api->post('auth/login', [
        'as' => 'auth.login',
        'uses' => 'AuthController@login',
    ]);
    $api->get('auth/logout', [
        'as' => 'auth.logout',
        'uses' => 'AuthController@logout',
    ]);



});