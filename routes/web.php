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
    return view('welcome')->with('workuri', env('WORK_URL'));
});

Route::view('/contact', 'contact');

//mosaic
Route::get('/mosaic/index', 'MosaicController@index');

Route::get('/mosaic/indexjson', 'MosaicController@indexjson');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::post('/image/store', 'ImageController@store');

    Route::post('/image/delete', 'ImageController@delete');

    Route::post('/image/deleteall', 'ImageController@deleteall');

    Route::post('/image/registeredindex', 'ImageController@registeredindex');

    Route::get('/mosaic/delete/{id}', 'MosaicController@delete');

    Route::get('/mosaic/uploadindex', 'MosaicController@uploadindex')->name('mosaicupload');

    Route::post('/mosaic/store', 'MosaicController@store');

});

Route::post('/image/storecanvas', 'ImageController@storecanvas');

Route::post('/image/collectimage', 'ImageController@collectimage');

//Route::get('/storetester', 'ImageController@storetester');

//Route::resource('image', 'ImageController');

//user id not used
Route::any('/image/index/{gallery_id}', 'ImageController@index');

//->where('id', '[0-9]+');

Route::get('/users', 'UserController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/advertisement', 'HomeController@advertisement')->name('advertisement');

Route::get('myphpinfo', function () {
    phpinfo();
});

//Change Password
Route::get('/changePassword', 'PersonController@showChangePasswordForm');
Route::post('/changePassword', 'PersonController@changePassword')->name('changePassword');

Route::get('/gallery/index', 'GalleryController@index');

Route::get('/babylon', 'BabylonController@index');

Route::get('/babylonmine', 'BabylonController@mine');

Route::get('/babylonsandbox', 'BabylonController@sandbox');

Route::get('/babylonphysics', 'BabylonController@physics');

//Superadmin
Route::get('admin/userlist', [
    'middleware' => 'is_superadmin',
    "uses" => "AdminController@userlist",
]);

Route::get('/image/deletenotuserrows/{id}', [
    'middleware' => 'is_superadmin',
    "uses" => "ImageController@deleteNotUsedRows",
]);

Route::get('admin/imagelist/{id}', 'AdminController@imagelist');
