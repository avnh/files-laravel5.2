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
	// return response()->download("../storage/app/uploadfile/file.txt");
	print_r(DB::table('uploadsettings')->insert([
            'id' => 1,
            'allowedFilesExt' => 'txt',
            'maxFileSize' => 16,
            'userDiskSpace' => 128,
        ]));
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
Route::post('file/downloadLocked/{fileid}', 'FileController@downloadLockedFile');
Route::post('file/delete', 'FileController@deleteFile');
Route::post('file/lock', 'FileController@lockFile');

Route::get('admin/dashboard', 'AdminController@dashboard');
Route::get('admin/upload', 'AdminController@upload');
Route::post('admin/upload', 'AdminController@saveUploadSettings');
Route::get('admin/user', 'AdminController@user');
Route::get('admin/user/delete/{id}', 'AdminController@deleteUser');
Route::get('admin/file', 'AdminController@file');
Route::post('admin/file/{fileid}', 'AdminController@deleteFile');
Route::get('admin/category', 'AdminController@category');
Route::post('admin/category/delete/{categoryid}', 'AdminController@deleteCategory');
Route::post('admin/category/', 'AdminController@updateCategory');

