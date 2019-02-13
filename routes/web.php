<?php

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
    return redirect('/admin/login');
});


Route::get('attachment/{md5}', [
    'as' => 'attachment.download',
    'uses' => 'Web\AttachmentController@download',
]);
Route::get('image/{md5}', [
    'as' => 'attachment.image',
    'uses' => 'Web\AttachmentController@image',
]);
