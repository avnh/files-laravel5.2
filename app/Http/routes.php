<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Response;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
	// echo Storage::disk('local')->put('uploadfile/file.txt', 'Contents');
	// echo Storage::disk('local')->exists('uploadfile/file.txt');
	// echo file_get_contents(storage_path().'\app\uploadfiles\1495479621_2014_04_msw_a4_format.doc');
	// $file = Storage::disk('local')->get('uploadfiles/1495479621_2014_04_msw_a4_format.doc');
 	echo Storage::delete("/uploadfile/file.txt");
	
    // return view('user.file');
});


Route::get('/home', 'HomeController@index');

Route::auth();

Route::get('user/{username}/home', 'UserController@home');
Route::get('user/{username}/dashboard', 'UserController@dashboard');
Route::get('user/{username}/upload', 'UserController@getUpload');
Route::post('user/{username}/upload', 'UserController@postUpload');
Route::get('user/{username}/setting', 'UserController@setting');
Route::post('user/{username}/setting', 'UserController@changeSetting');

Route::get('file/show/{fileid}', 'FileController@showFile');
Route::post('file/download/{fileid}', 'FileController@downloadFile');
Route::post('file/delete', 'FileController@deleteFile');
Route::get('file/lock', 'FileController@lockFile');
Route::post('file/lock', 'FileController@lockFile');

Route::get('admin/dashboard', 'AdminController@dashboard');
Route::get('admin/upload', 'AdminController@upload');
Route::post('admin/upload', 'AdminController@saveUploadSettings');
Route::get('admin/user', 'AdminController@user');
Route::post('admin/user', 'AdminController@user');
Route::get('admin/user/delete/{id}', 'AdminController@deleteUser');

